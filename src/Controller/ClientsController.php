<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormInscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientsController extends AbstractController
{
    /**
     * @Route("/clients/inscription", name="app_customer_form_inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Crée une nouvelle instance de l'entité Clients
        $clients = new Clients();

        // Crée le formulaire basé sur ta classe ClientFormInscription
        $form = $this->createForm(ClientFormInscription::class, $clients);

        // Gère la requête et la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupère le mot de passe de l'utilisateur
            $plainPassword = $clients->getMdp();

            // Hache le mot de passe avant de l'enregistrer
            $hashedPassword = $passwordHasher->hashPassword($clients, $plainPassword);

            // Définit le mot de passe haché sur l'entité Clients
            $clients->setMdp($hashedPassword);

            // Sauvegarde l'utilisateur dans la base de données
            $em->persist($clients);
            $em->flush();

            // Message de succès après l'enregistrement du client
            $this->addFlash('success', 'Votre compte a été créé avec succès !');

            return $this->redirectToRoute('inscription_success', [
                'type' => 'client',  // Spécifie le type pour pouvoir afficher un message spécifique dans la vue
            ]);
        }

        // Si le formulaire n'est pas valide, affiche le formulaire avec les erreurs
        return $this->render('clients/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
 * @Route("/inscriptionSuccess", name="inscription_success")
 */
public function success(): Response
{
    // Redirige vers la page d'index des clients avec un message de succès
    return $this->render('clients/success.html.twig', [
        'message' => 'Votre compte a été créé avec succès. Vous pouvez vous connecter maintenant.'
    ]);
}

}
