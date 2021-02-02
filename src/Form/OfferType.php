<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Skill;
//use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OfferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('city')
            ->add('contractType')
            ->add('salary', null, ['required' => false])
            ->add('duration', null, ['required' => false])
            ->add('startDate', DateType::class, ['format' => 'ddMMMyyyy'])
            ->add('endDate', DateType::class, [
                'format' => 'ddMMMyyyy',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour'
                ],
                'required' => false,
                'choice_translation_domain' => true,
            ])
            ->add('description')
            ->add('isAnonymous')
            ->add('softSkills', EntityType::class, [
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->join('s.skillCategory', 'c')
                        ->where('c.isHard = false')
                        ->orderBy('s.name', 'ASC');
                },
                'group_by' => function ($skill) {
                    return $skill->getSkillCategory()->getName();
                },
                'class' => Skill::class,
                'choice_label' => 'name',

            ])
            ->add('hardSkills', EntityType::class, [
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->join('s.skillCategory', 'c')
                        ->where('c.isHard = true')
                        ->orderBy('s.name', 'ASC');
                },
                'group_by' => function ($skill) {
                    return $skill->getSkillCategory()->getName();
                },
                'class' => Skill::class,
                'choice_label' => 'name',

            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
            'validation_groups' => ['listSkill']
        ]);
    }
}
