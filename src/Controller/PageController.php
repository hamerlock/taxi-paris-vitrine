<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        // Données bidon pour la démo
        $tarifs = [
            [
                'titre' => 'Paris ↔ CDG',
                'prix' => '65€',
                'avantages' => ['Prix fixe garanti', 'Bagages inclus', 'Accueil avec pancarte', '4 passagers max'],
                'image' => '/images/cdg.jpg',
                'populaire' => true,
                'slug' => 'cdg',
                'cta' => 'CDG'
            ],
            [
                'titre' => 'Paris ↔ Orly',
                'prix' => '55€',
                'avantages' => ['Prix fixe garanti', 'Bagages inclus', 'Accueil avec pancarte', '4 passagers max'],
                'image' => '/images/orly.jpg',
                'populaire' => false,
                'slug' => 'orly',
                'cta' => 'Orly'
            ],
            [
                'titre' => 'Paris Centre',
                'prix' => 'À partir de 25€',
                'avantages' => ['Tarifs transparents', 'Pas de frais cachés', 'Devis immédiat', 'Service rapide'],
                'image' => '/images/paris.jpg',
                'populaire' => false,
                'slug' => 'centre',
                'cta' => 'Course'
            ],
        ];

        $avantages = [
            [
                'icon' => '/images/airport.svg',
                'titre' => 'Spécialiste Aéroports',
                'description' => 'Transferts CDG, Orly, Beauvais avec accueil personnalisé et tarifs fixes'
            ],
            [
                'icon' => '/images/driver.svg',
                'titre' => 'Chauffeurs Professionnels',
                'description' => 'Chauffeurs expérimentés avec pancarte nominative, ponctuels et connaissant Paris'
            ],
            [
                'icon' => '/images/fleet.svg',
                'titre' => 'Flotte Moderne',
                'description' => 'Véhicules Eco, Confort et Van pour tous vos besoins, entretenus et climatisés'
            ],
        ];

        $vehicle_types = [
            [
                'value' => 'eco',
                'label' => 'Éco (1-4 pers.)',
                'image' => '/images/eco.png',
            ],
            [
                'value' => 'confort',
                'label' => 'Confort (1-4 pers.)',
                'image' => '/images/confort.png',
            ],
            [
                'value' => 'van',
                'label' => 'Van (1-8 pers.)',
                'image' => '/images/van.png',
            ],
        ];

        // Gestion d'une erreur simulée
        $error = null;
        try {
            // Simule une erreur (ex: accès à une ressource externe)
            // throw new \Exception("Erreur de connexion à la base de données !");
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'PageController',
            'tarifs' => $tarifs,
            'avantages' => $avantages,
            'error' => $error,
            'vehicle_types' => $vehicle_types,
        ]);
    }

    #[Route('/reserver/{type}', name: 'reserver')]
    public function reserver(string $type = null): Response
    {
        // Pour l'instant, tu peux juste afficher une page de test
        return $this->render('reserver.html.twig', [
            'type' => $type,
        ]);
    }

    #[Route('/reserver/submit', name: 'reserver_submit', methods: ['POST'])]
    public function reserverSubmit(Request $request): Response
    {
        // Pour l'instant, on récupère les données du formulaire (bidon)
        $data = $request->request->all();

        // Ici tu pourrais traiter la réservation, envoyer un email, etc.
        // Pour la démo, on affiche juste un message de succès
        $success = 'Votre demande de réservation a bien été envoyée !';

        return $this->render('reserver.html.twig', [
            'success' => $success,
            'data' => $data,
        ]);
    }

    #[Route('/tarifs', name: 'tarifs')]
    public function tarifs(): Response
    {
        // Tu peux afficher une page de test pour l'instant
        return $this->render('tarifs.html.twig');
    }

    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        // Tu peux afficher une page de test pour l'instant
        return $this->render('services.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        // Tu peux afficher une page de test pour l'instant
        return $this->render('contact.html.twig');
    }
}