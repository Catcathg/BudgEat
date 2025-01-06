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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RestaurantsController extends AbstractController
{
    private $passwordEncoder;

    // Injecte le service d'encodeur de mot de passe dans le constructeur
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
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

 
    /*
     public function inscription(Request $request, EntityManagerInterface $em): Response
     {
         // Crée une nouvelle instance de ton entité Clients
         $restaurants = new Restaurants();
 
         // Crée le formulaire basé sur ta classe ClientFormInscription
         $form = $this->createForm(RestaurantsFormInscriptionType::class, $restaurants);
 
         // Gère la requête et la soumission du formulaire
         $form->handleRequest($request);
 
         // Si le formulaire est soumis et valide, sauvegarde les données
         if ($form->isSubmitted() && $form->isValid()) {

            // Hash the password
            $hashedPassword = password_hash($restaurants->getMdp(), PASSWORD_BCRYPT);
            $restaurants->setMdp($hashedPassword);

             $em->persist($restaurants);
             $em->flush();

             $this->addFlash('success', 'Inscription réussie !');
             return $this->redirectToRoute('inscription_success');
         }
 
         // Affiche le formulaire dans le template
         return $this->render('restaurants/inscription.html.twig', [
             'form' => $form->createView(),
        
         ]);
     }*/

    /**
     * @Route("/restaurants/inscription", name="app_restaurants_form_inscription")
     */

     public function inscription(Request $request, EntityManagerInterface $em): Response
     {
         // Crée une nouvelle instance de ton entité Clients
         $restaurants = new Restaurants();
 
         // Crée le formulaire basé sur ta classe ClientFormInscription
         $form = $this->createForm(RestaurantsFormInscriptionType::class, $restaurants);
 
         // Gère la requête et la soumission du formulaire
         $form->handleRequest($request);
 
         // Si le formulaire est soumis et valide, sauvegarde les données
         if ($form->isSubmitted() && $form->isValid()) {
             $em->persist($restaurants);
             $em->flush();
 
             // Redirige vers une autre page ou affiche un message
             return $this->redirectToRoute('inscription_success');
         }
 
         // Affiche le formulaire dans le template
         return $this->render('restaurants/inscription.html.twig', [
             'form' => $form->createView(),
         ]);
     }
 
     /**
      * @Route("/inscriptionSuccess", name="inscription_success")
      */
     public function success(): Response
     {
         return $this->render('restaurants/success.html.twig', [
             'message' => 'Nouveau compte ajouté avec succès !',
             'login_url' => $this->generateUrl('app_login'),
         ]);
     }
}
