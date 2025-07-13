<?php

namespace App\Form;

use App\DTO\TripDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicle_type', ChoiceType::class, [
                'choices' => [
                    'Éco' => 'eco',
                    'Confort' => 'confort',
                    'Van' => 'van',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Type de véhicule',
            ])
            ->add('pickup', ChoiceType::class, [
                'label' => 'Adresse de prise en charge',
                'attr' => [
                    'data-controller' => 'symfony--ux-autocomplete--autocomplete',
                    'data-symfony--ux-autocomplete--autocomplete-url-value' => '/api/addresses',
                    'data-symfony--ux-autocomplete--autocomplete-max-items-value' => '1',
                    'data-symfony--ux-autocomplete--autocomplete-close-after-select-value' => 'true',
                ],
                'empty_data' => '',
            ])
            ->add('dropoff', ChoiceType::class, [
                'label' => 'Adresse de destination',
                'attr' => [
                    'data-controller' => 'symfony--ux-autocomplete--autocomplete',
                    'data-symfony--ux-autocomplete--autocomplete-url-value' => '/api/addresses',
                    'data-symfony--ux-autocomplete--autocomplete-max-items-value' => '1',
                    'data-symfony--ux-autocomplete--autocomplete-close-after-select-value' => 'true',
                ],
                'empty_data' => '',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure',
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
            ])
            ->add('passagers', IntegerType::class, [
                'label' => 'Nombre de passagers',
                'attr' => [
                    'min' => 1,
                    'max' => 8,
                    'placeholder' => '1 à 8 passagers',
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Range([
                        'min' => 1,
                        'max' => 8,
                        'notInRangeMessage' => 'Le nombre de passagers doit être entre {{ min }} et {{ max }}',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TripDTO::class,
        ]);
    }
}
