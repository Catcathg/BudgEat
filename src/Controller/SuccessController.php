<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
{
    /**
     * @Route("/inscriptionSuccess/{type}", name="inscription_success")
     */
    public function success(string $type): Response
    {
        // Vérifie le type et adapte le message
        $message = '';
        if ($type === 'client') {
            $message = 'Votre compte client a été créé avec succès.';
        } elseif ($type === 'restaurant') {
            $message = 'Votre compte restaurant a été créé avec succès.';
        }

        return $this->render('clients/success.html.twig', [
            'message' => $message,
            'type' => $type, 
        ]);
    }
}
