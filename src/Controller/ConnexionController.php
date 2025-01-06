<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Restaurants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/clients/connexion", name="app_login")
     */
    public function login(Request $request, EntityManagerInterface $em): Response
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers le tableau de bord
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        // Récupérer l'email et le mot de passe soumis
        $mail = $request->request->get('mail');
        $mdp = $request->request->get('mdp');

        // Recherche du client par email dans la base de données
        $client = $em->getRepository(Clients::class)->findOneBy(['mail' => $mail]);

        // Si un client est trouvé et que les mots de passe correspondent
        if ($client && $mdp === $client->getMdp()) {
            // L'utilisateur est authentifié, on gère la session
            $session = $request->getSession  ();
            $session->set('user_id', $client->getId()); // Sauvegarder l'ID de l'utilisateur dans la session
            $session->set('user_role', $client->getRole()); // Sauvegarder le rôle de l'utilisateur dans la session

            // Rediriger l'utilisateur vers le tableau de bord en fonction de son rôle
            if ($client->getRole() === 1) {
                return $this->render('dashboard/index.html.twig');
            } elseif ($client->getRole() === 2) {
                return $this->render('dashboard/admin.html.twig');
            }
        } else {
            // Email ou mot de passe incorrect
            $this->addFlash('error', 'Email ou mot de passe incorrect');
        }

        // Rendu du formulaire de connexion
        return $this->render('connexion/index.html.twig');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(Request $request): Response
    {
        // Récupérer les informations de l'utilisateur depuis la session
        $session = $request->getSession();
        $role = $session->get('user_role');

        // Vérification du rôle pour accéder à cette page
        if ($role !== 1) {
            // Redirection si l'utilisateur n'est pas un client
            return $this->redirectToRoute('unauthorized');
        }

        return $this->render('dashboard/index.html.twig');
    }

    /**
     * @Route("/admin-dashboard", name="admin_dashboard")
     */
    public function adminDashboard(Request $request): Response
    {
        // Récupérer les informations de l'utilisateur depuis la session
        $session = $request->getSession();
        $role = $session->get('user_role');

        // Vérification du rôle pour accéder à l'admin dashboard
        if ($role !== 2) {
            // Redirection si l'utilisateur n'est pas un administrateur
            return $this->redirectToRoute('unauthorized');
        }

        return $this->render('dashboard/admin.html.twig');
    }


    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // Supprimer les informations de la session
        /*$session = $request->getSession();
        $session->remove('user_id');
        $session->remove('user_role');

        // Rediriger vers la page de connexion
        return $this->redirectToRoute('app_login');*/
    }



    // coté restaurateurs :

    /**
     * @Route("/restaurants/connexion", name="app_login_restaurants")
     */
    public function loginRestaurant(Request $request, EntityManagerInterface $em, AuthenticationUtils $authenticationUtils): Response
    {
        /*
        // Si l'utilisateur est déjà connecté, on le redirige vers le tableau de bord
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');//a changé pour dashboard restaurant (Milena)
        }

        // Récupérer l'email et le mot de passe soumis
        $mail = $request->request->get('mail');
        $mdp = $request->request->get('mdp');

        // Recherche du client par email dans la base de données
        $restaurants = $em->getRepository(Restaurants::class)->findOneBy(['mail' => $mail]);

        // Si un client est trouvé et que les mots de passe correspondent
        if ($restaurants && $mdp === $restaurants->getMdp()) {
            // L'utilisateur est authentifié, on gère la session
            $session = $request->getSession  ();
            $session->set('user_id', $restaurants->getId()); // Sauvegarder l'ID de l'utilisateur dans la session
            //$session->set('user_role', $restaurants->getRole()); // Sauvegarder le rôle de l'utilisateur dans la session

           
        } else {
            // Email ou mot de passe incorrect
            $this->addFlash('error', 'Email ou mot de passe incorrect');
        }

        // Rendu du formulaire de connexion
        return $this->render('connexion/restaurants.html.twig');*/

        // Récupérer les erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Afficher la vue avec les informations
        return $this->render('connexion/restaurants.html.twig', [
            'error' => $error,  // Erreur de connexion (s'il y en a)
        ]);
    
    }



}
