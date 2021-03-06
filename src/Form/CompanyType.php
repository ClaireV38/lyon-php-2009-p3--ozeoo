<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('siretNb', TextType::class, [
                'label' => 'Numéro de SIRET'
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Email de contact'
            ])
            ->add('apeNb', TextType::class, [
                'label' => 'Numéro APE'
            ])
            ->add('pictureFile', VichImageType::class, [
                'label' => 'Photo de l\'entreprise (formats autorisés : PNG, JPEG, JPG)',
                'required'      => false,
                'allow_delete' => true,
                'delete_label' => 'Ne pas afficher d\'image',
                'image_uri' => false,
                'download_uri' => false,
                'attr' => [
                    'accept' => "image/jpeg, image/png",
                    'placeholder' => "Choisir votre photo"
                ],
                'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Please upload a JPG or PNG',
                        ])
                    ]
                ])
            ->add('video', TextType::class, [
                'label' => 'Lien vidéo Youtube',
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'entreprise',
            ])
            ->add('corporateCulture', TextareaType::class, [
                'required' => false,
                'label' => 'Culture de l\'entreprise'
            ])
            ->add('csr', TextareaType::class, [
                'required' => false,
                'label' => 'Responsabilité Sociale de l\'Entreprise'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
            "allow_extra_fields" => true,
            'validation_groups' => ['company'],
        ]);
    }
}
