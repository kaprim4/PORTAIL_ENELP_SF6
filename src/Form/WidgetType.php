<?php

namespace App\Form;

use App\Entity\Hook;
use App\Entity\Module;
use App\Entity\Widget;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class WidgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libelle',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('alias', ChoiceType::class, [
                'label' => "Alias",
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'choices' => [
                    "Blocs d'entête" => [
                        "Web Apps" => 'WebApp',
                        'Mon Panier' => 'MyCart',
                        "Notifications" => 'Notifications',
                        "Bouton Plein écran" => 'FullScreenBtn',
                        'Bouton Mode Jour/Nuit' => 'LightDarkModeBtn',
                    ],
                    "Blocs Accueil" => [
                        'Bloc 1' => 'bloc1',
                        'Bloc 2' => 'bloc2',
                        "Liste d'affichage" => 'listing',
                        "Element du menu" => 'menu.item',
                    ],
                ],
                'required' => false,
            ])
            ->add('hook', EntityType::class, [
                'label' => 'Emplacement',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Hook::class,
                'choice_label' => fn(Hook $hook) => '#' . str_pad($hook->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $hook->getLibelle(),
                'choice_value' => 'id',
            ])
            ->add('module', EntityType::class, [
                'label' => 'Module',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Module::class,
                'choice_label' => fn(Module $module) => '#' . str_pad($module->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $module->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('mode', ChoiceType::class, [
                'label' => "Mode d'affichage",
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'choices' => [
                    "Chiffres clefs" => [
                        'KPI' => 'kpi',
                        "Chiffre d'affaire" => 'ca',
                        "Liste d'élément" => 'listing',
                        'Activé / Désactivé' => 'ed',
                    ],
                    "Autres" => [
                        'Raccourci' => 'shortcut',
                    ],
                ],
                'required' => false,
            ])
            ->add('iconColor', ChoiceType::class, [
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
            ->add('bgColor', ChoiceType::class, [
                'label' => "Couleur d'arrière-plan",
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
            ->add('textColor', ChoiceType::class, [
                'label' => "Couleur du texte",
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Widget::class,
        ]);
    }
}
