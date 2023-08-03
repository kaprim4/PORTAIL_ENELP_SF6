<?php

namespace App\Form;

use App\Entity\ClaimStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClaimStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Merci de renseigner ce champ.']),
                    new Length(['min' => 3, 'max' => 20])
                ],
                'label' => 'Libelle',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('color', ChoiceType::class, [
                'label' => "Couleur d'icône",
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'choices' => [
                    'Primary' => 'primary',
                    'Secondary' => 'secondary',
                    'Success' => 'success',
                    'Info' => 'info',
                    'Warning' => 'warning',
                    'Danger' => 'danger',
                    'Dark' => 'dark',
                    'Light' => 'light',
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
            'data_class' => ClaimStatus::class,
        ]);
    }
}
