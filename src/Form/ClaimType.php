<?php

namespace App\Form;

use App\Entity\Claim;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ClaimType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile1', VichImageType::class, [
                'label' => "Image 1",
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 mb-5',
                ],
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer cette image',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'image_medium',
                'asset_helper' => true,
            ])
            ->add('imageFile2', VichImageType::class, [
                'label' => "Image 2",
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 mb-5',
                ],
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer cette image',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'image_medium',
                'asset_helper' => true,
            ])
            ->add('imageFile3', VichImageType::class, [
                'label' => "Image 3",
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 mb-5',
                ],
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer cette image',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'image_medium',
                'asset_helper' => true,
            ])
            ->add('imageFile4', VichImageType::class, [
                'label' => "Image 4",
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 mb-5',
                ],
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer cette image',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'image_medium',
                'asset_helper' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Claim::class,
        ]);
    }
}
