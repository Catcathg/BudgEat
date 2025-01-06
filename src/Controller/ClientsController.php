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

        // Crée le formulaire basé sur la classe ClientFormInscription
        $form = $this->createForm(ClientFormInscription::class, $clients);

        // Gère la requête et la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Validation du mot de passe ici, si nécessaire (en plus des contraintes form)
            $password = $clients->getMdp();

            // Si vous voulez appliquer des validations supplémentaires au mot de passe avant le hachage:
            // Par exemple, vérifier si le mot de passe répond à des critères spécifiques.
            // (Ce n'est pas nécessaire si vous avez déjà validé dans le formulaire.)

            // Hachage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($clients, $password);
            $clients->setMdp($hashedPassword);
            
            // Sauvegarde en base de données
            $em->persist($clients);
            $em->flush();

            // Redirige vers une autre page ou affiche un message
            return $this->redirectToRoute('inscription_success_clients');
        }

        // Si le formulaire n'est pas valide, affiche le formulaire avec les erreurs
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
            'login_url' => $this->generateUrl('app_login_clients'),
        ]);
    }
}
