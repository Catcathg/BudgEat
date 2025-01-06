<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RestaurantsFormInscriptionType;
use Doctrine\ORM\EntityManagerInterface;

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
        $budget = $request->query->get('budget', 0);

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

    /**
     * @Route("/restaurants/inscription", name="app_restaurants_form_inscription")
     */

    public function inscription(Request $request, EntityManagerInterface $em): Response
    {
        $restaurants = new Restaurants();

        $form = $this->createForm(RestaurantsFormInscriptionType::class, $restaurants);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($restaurants);
            $em->flush();

            return $this->redirectToRoute('inscription_success');
        }

        return $this->render('restaurants/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/restaurants/filter-by-ville", name="filter_restaurants_by_ville", methods={"GET"})
     */
    public function filterByVille(Request $request, RestaurantsRepository $repository): Response
    {
        // Récupérer la ville soumise par l'utilisateur
        $ville = $request->query->get('ville', '');

        // Rechercher les restaurants dont la ville correspond à celle sélectionnée
        $queryBuilder = $repository->createQueryBuilder('r');

        // Si une ville est spécifiée, filtrer par ville
        if ($ville) {
            $queryBuilder->where('r.ville LIKE :ville')
                ->setParameter('ville', '%' . $ville . '%');
        }

        // Exécuter la requête et récupérer les résultats
        $restaurants = $queryBuilder->getQuery()->getResult();

        // Retourner la vue avec les restaurants filtrés par ville
        return $this->render('restaurants/index.html.twig', [
            'restaurants' => $restaurants,
            'ville' => $ville,
        ]);
    }

    /**
     * @Route("/restaurants/filter/filter-by-ville", name="filter_restaurants_by_ville_budgeat", methods={"GET"})
     */
    public function filterByVilleBudgeat(Request $request, RestaurantsRepository $repository): Response
    {
        $budget = $request->query->get('budget');
        $ville = $request->query->get('ville');

        // Récupération de tous les restaurants en fonction des critères
        $queryBuilder = $this->getDoctrine()->getRepository(Restaurants::class)->createQueryBuilder('r');

        if ($budget) {
            $queryBuilder->andWhere('r.prix_minimum <= :budget')
                ->setParameter('budget', $budget);
        }

        if ($ville) {
            $queryBuilder->andWhere('r.ville = :ville')
                ->setParameter('ville', $ville);
        }

        $restaurants = $queryBuilder->getQuery()->getResult();

        return $this->render('restaurants/list.html.twig', [
            'restaurants' => $restaurants,
            'budget' => $budget,
        ]);
    }




}
