<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Company;
use App\Entity\GasStation;
use App\Entity\Grade;
use App\Entity\Region;
use App\Entity\Supervisor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GasStationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeSap', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Merci de renseigner ce champ.']),
                    new Length(['min' => 3, 'max' => 20])
                ],
                'label' => 'Code SAP',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
            ])
            ->add('libelle', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Merci de renseigner ce champ.']),
                    new Length(['min' => 3, 'max' => 50])
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
            ->add('company', EntityType::class, [
                'label' => 'Type de gestion',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Company::class,
                'choice_label' => fn(Company $company) => '#' . str_pad($company->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $company->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('supervisor', EntityType::class, [
                'label' => 'Superviseur',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Supervisor::class,
                'choice_label' => fn(Supervisor $supervisor) => '#' . str_pad($supervisor->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $supervisor->getFirstName() . ' ' . $supervisor->getLastName(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('region', EntityType::class, [
                'mapped' => false,
                'label' => 'Région',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Region::class,
                'choice_label' => fn(Region $region) => '#' . str_pad($region->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $region->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => City::class,
                'choice_label' => fn(City $city) => '#' . str_pad($city->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $city->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                    'rows' => 3,
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
            ->add('gradeList', EntityType::class, [
                'label' => 'Produits',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => Grade::class,
                'choice_label' => fn(Grade $grade) => '#' . str_pad($grade->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $grade->getLibelle(),
                'choice_value' => 'id',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('isActivated', CheckboxType::class, [
                'label' => 'Activé ?',
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

        $formModifier = function (FormInterface $form, Region $region = null) {
            $cities = null === $region ? [] : $region->getCities();
            $form->add('city', EntityType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'class' => City::class,
                'choices' => $cities,
                'choice_label' => fn(City $city) => '#' . str_pad($city->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $city->getLibelle(),
                'choice_value' => 'id',
                'placeholder' => 'Choisissez une option',
                'required' => false,
            ]);
        };

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $region = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $region);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GasStation::class,
        ]);
    }
}
