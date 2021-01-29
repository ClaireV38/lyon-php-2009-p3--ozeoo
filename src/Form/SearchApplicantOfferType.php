<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchApplicantOfferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sort', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Début de mission' => 'startDate',
                    'Créé le' => 'creationDate',
                    'Date d\'expiration' => 'endDate',
                    'Titre de l\'annonce' => 'title',
                    'Entreprise' => 'company',
                ],
            ])
            ->add('searchTitle', SearchType::class, [
                'required' => false,
            ])
            ->add('searchCompany', SearchType::class, [
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}