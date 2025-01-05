<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantsController extends AbstractController
{
    /**
     * @Route("/restaurants", name="restaurants_list")
     */
    public function list(RestaurantsRepository $repository): Response
    {
        // Récupérer tous les restaurants depuis la base de données
        $restaurants = $repository->findAll();

        // Passer les données au template Twig
        return $this->render('restaurants/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * @Route("/restaurants/filter", name="filter_restaurants", methods={"GET"})
     */
    public function filterByBudget(Request $request, RestaurantsRepository $repository): Response
    {
        // Récupérer le budget soumis par l'utilisateur
        $budget = $request->query->get('budget', 0); // Valeur par défaut : 0

        // Rechercher les restaurants dont le prix minimum est inférieur ou égal au budget
        $restaurants = $repository->createQueryBuilder('r')
            ->where('r.prix_minimum <= :budget')
            ->setParameter('budget', $budget)
            ->getQuery()
            ->getResult();

        return $this->render('restaurants/list.html.twig', [
            'restaurants' => $restaurants,
            'budget' => $budget,
        ]);
    }
}
