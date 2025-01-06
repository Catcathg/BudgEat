<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormInscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientsController extends AbstractController
{

    private $passwordEncoder;

    // Injecte le service d'encodeur de mot de passe dans le constructeur
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/clients/inscription", name="app_customer_form_inscription")
     */

    public function inscription(Request $request, EntityManagerInterface $em): Response
    {
        // Crée une nouvelle instance de ton entité Clients
        $clients = new Clients();

        // Crée le formulaire basé sur ta classe ClientFormInscription
        $form = $this->createForm(ClientFormInscription::class, $clients);

        // Gère la requête et la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, sauvegarde les données
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordEncoder->encodePassword($clients, $clients->getMdp());
            $clients->setMdp($hashedPassword);
            
            $em->persist($clients);
            $em->flush();

            // Redirige vers une autre page ou affiche un message
            return $this->redirectToRoute('inscription_success_clients');
        }

        // Affiche le formulaire dans le template
        return $this->render('clients/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscriptionSuccessClients", name="inscription_success_clients")
     */
    public function success(): Response
    {
        return $this->render('clients/success.html.twig', [
            'message' => 'Nouveau compte ajouté avec succès !',
            'login_url' => $this->generateUrl('app_login'),
        ]);
    }
}
