<?php

namespace App\Form;

use App\Entity\Price;
use App\Entity\PriceStatistic;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PriceStatisticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', EntityType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Price::class,
                'choice_label' => fn(Price $price) => '#' . str_pad($price->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $price->getEventNumHO(),
                'choice_value' => 'id',
            ])
            ->add('ipAddress', TextType::class, [
                'label' => 'Adresse IP',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('source', TextType::class, [
                'label' => 'Source',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('buildVersion', TextType::class, [
                'label' => 'Build Version',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('webPlateform', TextType::class, [
                'label' => 'Plateforme WEB',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('idSupport', TextType::class, [
                'label' => 'ID Support',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('imei', TextType::class, [
                'label' => 'IMEI',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('isActivated', CheckboxType::class, [
                'label' => 'Est-t-il activé ?',
                'label_attr' => [
                    'class' => 'form-check-label',
                ],
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'row_attr' => [
                    'class' => 'col-md-3 mb-5 form-check form-switch my-3',
                ],
                'help' => '* cette option est facultative.',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceStatistic::class,
        ]);
    }
}
