<?php

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

        $restaurant = $restaurantsRepository->find($id);

        if (!$restaurant) {
            throw $this->createNotFoundException('Restaurant non trouvé');
        }
        
        $adresse = $restaurant->getAdresse();

        $response = $client->request('GET', 'https://nominatim.openstreetmap.org/search', [
            'query' => [
                'q' => $adresse,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 1
            ]
        ]);

        $data = $response->toArray();

        if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
            $latitude = $data[0]['lat'];
            $longitude = $data[0]['lon'];
        } else {
            throw $this->createNotFoundException('Coordonnées non trouvées pour l\'adresse du restaurant');
        }

        return $this->render('map/index.html.twig', [
            'commander' => $restaurant,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }
}

