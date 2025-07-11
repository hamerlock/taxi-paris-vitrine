<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Service permettant d'effectuer de la géolocalisation d'adresses via l'API adresse.data.gouv.fr.
 * Utilisé pour fournir des suggestions d'adresses (autocomplétion) dans les formulaires.
 */
class AddressGeocoder
{
   
    private HttpClientInterface $client;
    private const API_URL = 'https://api-adresse.data.gouv.fr/search/';


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Effectue une recherche d'adresses pour l'autocomplétion.
     *
     * @param string $term  Terme recherché (saisi par l'utilisateur)
     * @param int    $limit Nombre maximum de résultats à retourner
     * @return array        Tableau de suggestions d'adresses, chaque élément ayant les clés 'label' et 'value'
     */
    public function autocomplete(string $term, int $limit = 50): array
    {
        // On ne lance la recherche que si le terme fait au moins 3 caractères
        if (mb_strlen($term) < 3) {
            return [];
        }

        // Requête HTTP GET vers l'API adresse.data.gouv.fr (sans filtre postcode)
        $response = $this->client->request('GET', self::API_URL, [
            'query' => [
                'q'     => $term,
                'limit' => $limit,
            ],
        ]);

        $data = $response->toArray();

        // On filtre les résultats pour ne garder que ceux de l'Île-de-France
        $featuresIdf = $this->filterFeaturesByIleDeFrance($data['features'] ?? []);

        return $this->formatAutocompleteResults($featuresIdf);
    }

    /**
     * Filtre les résultats pour ne garder que ceux situés en Île-de-France.
     * On se base sur les deux premiers chiffres du code postal (départements 75, 77, 78, 91, 92, 93, 94, 95).
     *
     * @param array $features Liste des features retournées par l'API
     * @return array Liste filtrée des features en Île-de-France
     */
    private function filterFeaturesByIleDeFrance(array $features): array
    {
        $departementsIleDeFrance = ['75', '77', '78', '91', '92', '93', '94', '95'];
        // On ne garde que les features dont le code postal commence par un des départements IDF
        return array_filter($features, function ($feature) use ($departementsIleDeFrance) {
            $postcode = $feature['properties']['postcode'] ?? '';
            $departement = substr($postcode, 0, 2);
            return in_array($departement, $departementsIleDeFrance, true);
        });
    }

    /**
     * Transforme les résultats bruts de l'API en un format simplifié pour l'autocomplétion.
     * Chaque résultat retourné aura une clé 'label' (affichage) et 'value' (valeur envoyée).
     *
     * @param array $features Liste des features retournées par l'API
     * @return array Tableau formaté pour l'autocomplétion
     */
    private function formatAutocompleteResults(array $features): array
    {
        // On mappe chaque feature (élément de résultat de l'API) pour ne garder que les informations utiles à l'autocomplétion
        return array_map(fn(array $feature) => [
            'value' => $feature['properties']['label'], // Adresse complète à afficher
            'text' => $feature['properties']['label'], // Valeur envoyée au backend (ici identique)
        ], $features);
    }
}
