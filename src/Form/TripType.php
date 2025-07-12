<?php
// src/Form/TripType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class TripAddressAutocompleteField extends AbstractType
{
    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}

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
                'attr' => [
                    'data-controller' => 'symfony--ux-autocomplete--autocomplete',
                    'data-symfony--ux-autocomplete--autocomplete-url-value' => '/api/addresses',
                ],
            ])
            ->add('dropoff', TextType::class, [
                'label' => 'Adresse de destination',
                'attr' => [
                    'data-controller' => 'symfony--ux-autocomplete--autocomplete',
                    'data-symfony--ux-autocomplete--autocomplete-url-value' => '/api/addresses',
                ],
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
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Trip::class, ou rien si tu n’as pas d’entité
        ]);
    }
}
