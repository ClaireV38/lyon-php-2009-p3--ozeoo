<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Skill;
//use Doctrine\DBAL\Types\DateType;
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
            ->add('contractType')
            ->add('salary', null, ['required' => false])
            ->add('duration', null, ['required' => false])
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('description')
            ->add('isAnonymous')
            //->add('city', null, ['choice_label' =>'name'])
            //->add('company')
            ->add('skills', null,[
                'choice_label' =>'name',
                //'multiple'=> false,
                //'expanded'=>false,
                'label'=>false,
            ])
            //->add('applicant')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
