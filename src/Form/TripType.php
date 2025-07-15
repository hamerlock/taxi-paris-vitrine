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
                    'form.choice.eco' => 'eco',
                    'form.choice.confort' => 'confort',
                    'form.choice.van' => 'van',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'form.label.vehicle_type',
            ])
            ->add('pickup', TextType::class, [
                'label' => 'form.label.pickup',
            ])
            ->add('dropoff', TextType::class, [
                'label' => 'form.label.dropoff',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'form.label.date',
            ])
            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'form.label.heure',
            ])
            ->add('telephone', TelType::class, [
                'label' => 'form.label.telephone',
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.label.email',
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'form.label.nom',
                'required' => true,
            ])
            ->add('passagers', IntegerType::class, [
                'label' => 'form.label.passagers',
                'attr' => [
                    'min' => 1,
                    'max' => 8,
                    'placeholder' => 'form.placeholder.passagers',
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Range([
                        'min' => 1,
                        'max' => 8,
                        'notInRangeMessage' => 'form.error.passagers_range',
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
