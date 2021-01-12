<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;
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
                'label' => 'Numéro de siret'
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Email de contact'
            ])
            ->add('apeNb', TextType::class, [
                'label' => 'Numéro APE'
            ])
            ->add('pictureFile', VichImageType::class, [
                'label' => 'Photo de l\'entreprise',
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'asset_helper' => true
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
