<?php

namespace App\Form;

use App\Entity\Applicant;
use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\SkillCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ApplicantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname')
            ->add('personality')
            ->add('mobility', TextType::class)
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
            'data_class' => Applicant::class,
        ]);
    }
}
