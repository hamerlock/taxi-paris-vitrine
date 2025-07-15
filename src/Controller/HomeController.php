<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AddressGeocoder;
use App\DTO\TripDTO;
use App\Form\TripType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Contrôleur principal de l'application Taxi Paris.
 * Gère l'affichage de la page d'accueil, la réservation, l'autocomplétion d'adresses, etc.
 */
final class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil avec les tarifs, avantages, types de véhicules et le formulaire de réservation.
     */
    #[Route('/', name: 'home')]
    public function home(Request $request): Response
    {
        // Formulaire de réservation
        $data = new TripDTO();
        $form = $this->createForm(TripType::class, $data);
        $formView = $form->createView();

        return $this->render('index.html.twig', [
            'controller_name' => 'PageController',
            'tarifs' => $this->getTarifs(),
            'avantages' => $this->getAvantages(),
            'vehicle_types' => $this->getVehicleTypes(),
            'reservation_form' => $formView,
        ]);
    }

    /**
     * API d'autocomplétion d'adresses pour le formulaire de réservation.
     * Appelle le service AddressGeocoder pour obtenir des suggestions d'adresses.
     * Retourne les résultats au format attendu par Symfony UX Autocomplete.
     */
    #[Route('/api/addresses', name: 'api_addresses', methods: ['GET'])]
    public function autocomplete(Request $request, AddressGeocoder $geocoder): JsonResponse
    {
        // Récupère le terme de recherche depuis la requête GET (?query=...)
        $term = $request->query->get('query', '');
        // Appelle le service pour obtenir les suggestions d'adresses
        $results = $geocoder->autocomplete($term, 10);
        // Retourne la réponse JSON
        return $this->json([
            'results' => $results
        ]);
    }


    /**
     * Traite la soumission du formulaire de réservation.
     * Si le formulaire est valide, affiche un message de succès.
     */
    #[Route('/reserver/submit', name: 'reserver_submit', methods: ['POST'])]
    public function reserverSubmit(Request $request, MailerInterface $mailer): Response
    {
        $data = new TripDTO();
        $form = $this->createForm(TripType::class, $data);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = (new TemplatedEmail())
                    ->to("taxiparis@taxiparis.com")
                    ->from($data->getEmail())
                    ->subject('Nouvelle réservation : le ' . $data->getDateTime())
                    ->htmlTemplate('emails/reservation.html.twig')
                    ->context(['trip' => $data]);
            $mailer->send($mail);
            $this->addFlash('success', 'flash.reservation_success');
            return $this->redirectToRoute('home');
        }
        
        // Si le formulaire n'est pas valide, on reste sur la même page pour afficher les erreurs
        return $this->render('index.html.twig', [
            'reservation_form' => $form->createView(),
            'tarifs' => $this->getTarifs(),
            'avantages' => $this->getAvantages(),
            'vehicle_types' => $this->getVehicleTypes(),
        ]);
    }

    /**
     * Retourne les tarifs disponibles
     */
    private function getTarifs(): array
    {
        return [
            [
                'titre' => 'tarif.cdg.title',
                'prix' => '65€',
                'avantages' => [
                    'tarif.advantage.fixed',
                    'tarif.advantage.luggage',
                    'tarif.advantage.sign',
                    'tarif.advantage.max4',
                ],
                'image' => '/images/cdg.jpg',
                'populaire' => true,
                'slug' => 'cdg',
                'cta' => 'tarif.cta.cdg'
            ],
            [
                'titre' => 'tarif.orly.title',
                'prix' => '55€',
                'avantages' => [
                    'tarif.advantage.fixed',
                    'tarif.advantage.luggage',
                    'tarif.advantage.sign',
                    'tarif.advantage.max4',
                ],
                'image' => '/images/orly.jpg',
                'populaire' => false,
                'slug' => 'orly',
                'cta' => 'tarif.cta.orly'
            ],
            [
                'titre' => 'tarif.centre.title',
                'prix' => 'À partir de 25€',
                'avantages' => [
                    'tarif.advantage.transparent',
                    'tarif.advantage.nofees',
                    'tarif.advantage.instant',
                    'tarif.advantage.fast',
                ],
                'image' => '/images/paris.jpg',
                'populaire' => false,
                'slug' => 'centre',
                'cta' => 'tarif.cta.centre'
            ],
        ];
    }

    /**
     * Retourne les avantages du service
     */
    private function getAvantages(): array
    {
        return [
            [
                'icon' => '/images/airport.jpg',
                'titre' => 'why.specialist',
                'description' => 'why.specialist_desc'
            ],
            [
                'icon' => '/images/driver.jpg',
                'titre' => 'why.pro_drivers',
                'description' => 'why.pro_drivers_desc'
            ],
            [
                'icon' => '/images/fleet.jpg',
                'titre' => 'why.fleet',
                'description' => 'why.fleet_desc'
            ],
        ];
    }

    /**
     * Retourne les types de véhicules disponibles
     */
    private function getVehicleTypes(): array
    {
        return [
            [
                'value' => 'eco',
                'label' => 'Éco',
                'image' => '/images/eco.png',
                'capacity' => 4,
            ],
            [
                'value' => 'confort',
                'label' => 'Confort',
                'image' => '/images/confort.png',
                'capacity' => 4,
            ],
            [
                'value' => 'van',
                'label' => 'Van',
                'image' => '/images/van.png',
                'capacity' => 8,
            ],
        ];
    }
}