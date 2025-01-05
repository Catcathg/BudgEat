<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RestaurantsController extends AbstractController
{
    /**
     * @Route("/restaurants", name="restaurants_list")
     */
    public function list(RestaurantsRepository $restaurantsRepository): Response
    {
        // Récupérer tous les restaurants
        $restaurants = $restaurantsRepository->findAllRestaurants();

        // Passer les données au template Twig
        return $this->render('restaurants/list.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
}

