<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use App\Service\AddressGeocoder;

// Source API : https://adresse.data.gouv.fr/api-doc/adresse
// Limite officielle : 50 requêtes par seconde et par IP (voir https://geo.api.gouv.fr/faq)
// Si la limite est dépassée, erreur HTTP 429 (Too Many Requests) et blocage temporaire (5s)
// Service public gratuit, documentation complète sur https://adresse.data.gouv.fr/api-doc/adresse

class AddressGeocoderTest extends TestCase
{
    public function testAutocompleteReturnsResultsForValidTerm()
    {
        $client = HttpClient::create();
        $geocoder = new AddressGeocoder($client);
        $results = $geocoder->autocomplete('Paris');

        // Debug : Affiche les résultats et leur nombre
        var_dump($results);
        var_dump('nombre de résultats : ' . count($results));

        $this->assertIsArray($results, 'Le résultat doit être un tableau');
        $this->assertNotEmpty($results, 'Le résultat ne doit pas être vide pour un terme valide');
        $this->assertArrayHasKey('label', $results[0], 'Chaque résultat doit avoir une clé label');
        $this->assertArrayHasKey('value', $results[0], 'Chaque résultat doit avoir une clé value');
    }

    public function testAutocompleteReturnsEmptyForShortTerm()
    {
        $client = HttpClient::create();
        $geocoder = new AddressGeocoder($client);
        $results = $geocoder->autocomplete('Pa');

        $this->assertIsArray($results, 'Le résultat doit être un tableau');
        $this->assertEmpty($results, 'Le résultat doit être vide pour un terme trop court');
    }
} 