<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO pour les données de réservation de course
 */
class TripDTO
{
    #[Assert\NotBlank(message: 'Veuillez sélectionner un type de véhicule')]
    #[Assert\Choice(choices: ['eco', 'confort', 'van'], message: 'Type de véhicule invalide')]
    private string $vehicle_type = 'eco';

    #[Assert\NotBlank(message: 'Veuillez saisir l\'adresse de prise en charge')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'L\'adresse de prise en charge doit contenir au moins {{ limit }} caractères', maxMessage: 'L\'adresse de prise en charge ne peut pas dépasser {{ limit }} caractères')]
    private ?string $pickup = null;

    #[Assert\NotBlank(message: 'Veuillez saisir l\'adresse de destination')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'L\'adresse de destination doit contenir au moins {{ limit }} caractères', maxMessage: 'L\'adresse de destination ne peut pas dépasser {{ limit }} caractères')]
    private ?string $dropoff = null;

    #[Assert\NotBlank(message: 'Veuillez sélectionner une date')]
    #[Assert\GreaterThan('today', message: 'La date doit être ultérieure à aujourd\'hui')]
    private \DateTimeInterface $date;

    #[Assert\NotBlank(message: 'Veuillez sélectionner une heure')]
    private \DateTimeInterface $heure;

    #[Assert\NotBlank(message: 'Veuillez saisir votre numéro de téléphone')]
    #[Assert\Regex(pattern: '/^(\+33|0)[1-9](\d{8})$/', message: 'Veuillez saisir un numéro de téléphone français valide')]
    private string $telephone = '';

    #[Assert\NotBlank(message: 'Veuillez saisir votre adresse e-mail')]
    #[Assert\Email(message: 'Veuillez saisir une adresse e-mail valide')]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Veuillez saisir votre nom')]
    private ?string $nom = null;

    #[Assert\NotBlank(message: 'Veuillez indiquer le nombre de passagers')]
    #[Assert\Range(min: 1, max: 8, notInRangeMessage: 'Le nombre de passagers doit être entre {{ min }} et {{ max }}')]
    private int $passagers = 1;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->heure = new \DateTime();
    }

    // Getters et Setters
    public function getVehicleType(): string
    {
        return $this->vehicle_type;
    }

    public function setVehicleType(string $vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;
        return $this;
    }

    public function getPickup(): ?string
    {
        return $this->pickup;
    }

    public function setPickup(?string $pickup): self
    {
        $this->pickup = $pickup;
        return $this;
    }

    public function getDropoff(): ?string
    {
        return $this->dropoff;
    }

    public function setDropoff(?string $dropoff): self
    {
        $this->dropoff = $dropoff;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getHeure(): \DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;
        return $this;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPassagers(): int
    {
        return $this->passagers;
    }

    public function setPassagers(int $passagers): self
    {
        $this->passagers = $passagers;
        return $this;
    }

    /**
     * Retourne la capacité maximale du véhicule sélectionné
     */
    public function getVehicleCapacity(): int
    {
        return match($this->vehicle_type) {
            'eco' => 4,
            'confort' => 4,
            'van' => 8,
            default => 4,
        };
    }

    /**
     * Retourne le label du type de véhicule
     */
    public function getVehicleTypeLabel(): string
    {
        return match($this->vehicle_type) {
            'eco' => 'Éco',
            'confort' => 'Confort',
            'van' => 'Van',
            default => 'Non défini',
        };
    }

    /**
     * Retourne la date et l'heure combinées
     */
    public function getDateTime(): string
    {
        $dateString = $this->date->format('Y-m-d');
        $timeString = $this->heure->format('H:i:s');
        return $dateString . ' à ' . $timeString;
    }

    /**
     * Retourne un résumé de la réservation
     */
    public function getSummary(): string
    {
        return sprintf(
            'Course %s - %s passagers - De %s à %s - Le %s à %s - Tél: %s',
            $this->getVehicleTypeLabel(),
            $this->passagers,
            $this->pickup,
            $this->dropoff,
            $this->date->format('d/m/Y'),
            $this->heure->format('H:i'),
            $this->telephone
        );
    }
} 