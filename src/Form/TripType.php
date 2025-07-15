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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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
            ->add('pickup', TextType::class, [
                'label' => 'Adresse de prise en charge',
            ])
            ->add('dropoff', TextType::class, [
                'label' => 'Adresse de destination',
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
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'nom',
                'required' => true,
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
            'csrf_protection' => false,
        ]);
    }
}
