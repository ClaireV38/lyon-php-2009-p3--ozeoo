<?php

namespace App\Form;

use App\Entity\Applicant;
use App\Entity\Skill;
use App\Entity\SkillCategory;
use Container1u5VjfN\getSkillCategoryRepositoryService;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
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
            ->add('mobility')
            ->add('skills',EntityType::class, [
                'class' => Skill::class,
//                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s');
                },
//                'choices' => $builder->getData()->getSkillCategory(),
                'choice_label' => 'name',
            ])
//            ->add('skillCategory', EntityType::class, [
//                'class' => SkillCategory::class,
//                'expanded' =>true,
//                'mapped' => false,
//                'multiple' => true,
//                'choice_label' => 'name',
//            ])
//            ->add('skills', TextType::class, [
//                'choice_label' => 'name',
//            ])
        ;
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
