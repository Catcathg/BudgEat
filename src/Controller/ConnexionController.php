<?php
namespace App\Controller;

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
     * @Route("/clients/connexion", name="app_login_clients")
     */
    public function login(Request $request, EntityManagerInterface $em, AuthenticationUtils $authenticationUtils): Response
    {
        /*
        // Si l'utilisateur est déjà connecté, on le redirige vers le tableau de bord
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();

            if (in_array('ROLE_ADMIN', $roles)) {
                return $this->redirectToRoute('admin_dashboard');
            }

            return $this->redirectToRoute('dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Afficher la page de connexion
        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/clients/deconnexion", name="app_logout_clients")
     */
    public function logoutClients(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/restaurants/connexion", name="app_login_restaurants")
     */
    public function loginRestaurant(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();

            if (in_array('ROLE_ADMIN', $roles)) {
                return $this->redirectToRoute('admin_dashboard');
            }

            return $this->redirectToRoute('restaurant_dashboard');
        }

        // Rendu du formulaire de connexion
        return $this->render('connexion/index.html.twig');*/

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Afficher la vue avec les informations
        return $this->render('connexion/index.html.twig', [
            'error' => $error,  // Erreur de connexion (s'il y en a)
        ]);
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
     * @Route("/login", name="app_login")
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
