<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\City;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('siretNb')
            ->add('contactEmail')
            ->add('apeNb')
            ->add('picture')
            ->add('video')
            ->add('description', TextareaType::class)
            ->add('corporateCulture', TextareaType::class)
            ->add('csr', TextareaType::class)
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
