<?php

namespace App\Controller;

use App\Entity\Restaurants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RestaurantsFormInscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class RestaurantsController extends AbstractController
{
    
    /**
     * @Route("/restaurants", name="app_restaurants")
     */
    /*
    public function index(): Response
    {
        return $this->render('restaurants/index.html.twig', [
            'controller_name' => 'RestaurantsController',
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
