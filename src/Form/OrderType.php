<?php

namespace App\Form;

use App\Entity\GasStation;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sellDocWeb', TextType::class, [
                'label' => 'Doc. Vente Web',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('sellDocSap', TextType::class, [
                'label' => 'Doc. Vente SAP',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('sellDocDate', DateType::class, [
                'label' => 'Date du Doc. Vente',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'required' => false,
            ])
            ->add('orderStatus', EntityType::class, [
                'label' => 'Statut commande',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => OrderStatus::class,
                'choice_label' => fn(OrderStatus $orderStatus) => '#' . str_pad($orderStatus->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $orderStatus->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('gasStation', EntityType::class, [
                'label' => 'Station service',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => GasStation::class,
                'choice_label' => fn(GasStation $gasStation) => '#' . str_pad($gasStation->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $gasStation->getLibelle(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'label' => 'Saisie par',
                'attr' => [
                    'class' => 'form-control select2-basic',
                ],
                'row_attr' => [
                    'class' => 'col-md-6 col-lg-4 mb-5',
                ],
                'placeholder' => 'Choisissez une option',
                'class' => User::class,
                'choice_label' => fn(User $user) => '#' . str_pad($user->getId(), 3, "0", STR_PAD_LEFT) . ' - ' . $user->getFirstName() . ' ' . $user->getLastName(),
                'choice_value' => 'id',
                'required' => false,
            ])
            ->add('isExported', CheckboxType::class, [
                'label' => 'Est-t-il exporté ?',
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
            'data_class' => Order::class,
        ]);
    }
}
