<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'label' => 'Utilisateur',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => User::class,
                'choice_label' => fn(User $user) => '#' . str_pad($user->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $user->getLastName().' '.$user->getFirstName(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('os', TextType::class, [
                'label' => 'OS',
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
            ->add('idSupport', TextType::class, [
                'label' => 'Id Support',
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
            ->add('versionName', TextType::class, [
                'label' => 'Nom Version',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('MacWlanAddress', TextType::class, [
                'label' => 'WLAN Mac',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('MacEthAddress', TextType::class, [
                'label' => 'ETH Mac',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('ipAddressV4', TextType::class, [
                'label' => 'Ip V4',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('ipAddressV6', TextType::class, [
                'label' => 'Ip V6',
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
            ->add('loginAt', DateType::class, [
                'label' => 'Date & Heure Cnx',
                'attr' => [
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
            ->add('isDeleted', CheckboxType::class, [
                'label' => 'Est-t-il supprimé ?',
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
            'data_class' => Session::class,
        ]);
    }
}
