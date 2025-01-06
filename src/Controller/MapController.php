<?php
// src/Controller/MapController.php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/map/{id}", name="restaurant_map")
     */
    public function showRestaurant(int $id, RestaurantsRepository $restaurantsRepository, HttpClientInterface $client): Response
    {
        // Récupérer le restaurant avec l'ID donné
        $restaurant = $restaurantsRepository->find($id);

        // Si le restaurant n'existe pas, on lance une exception 404
        if (!$restaurant) {
            throw $this->createNotFoundException('Restaurant non trouvé');
        }

        // Créer l'adresse complète du restaurant
        $adresse = $restaurant->getAdresse() . ', ' . $restaurant->getVille() . ' ' . $restaurant->getCodePostal();

        // Envoyer la requête à l'API Nominatim pour obtenir les coordonnées
        $response = $client->request('GET', 'https://nominatim.openstreetmap.org/search', [
            'query' => [
                'q' => $adresse,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 1
            ]
        ]);

        // Vérifier que la réponse contient des données
        $data = $response->toArray();

        // Si l'API retourne des résultats, on récupère la latitude et la longitude
        if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
            $latitude = $data[0]['lat'];
            $longitude = $data[0]['lon'];
        } else {
            // Si aucune coordonnée n'est trouvée, on lance une exception
            throw $this->createNotFoundException('Coordonnées non trouvées pour l\'adresse du restaurant');
        }

        // Passer les données au template
        return $this->render('map/index.html.twig', [
            'commander' => $restaurant,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }
}
