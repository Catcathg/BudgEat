<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateformeController extends AbstractController
{
    #[Route('/plateforme', name: 'app_plateforme')]
    public function index(): Response
    {
        return $this->render('plateforme/restaurants.html.twig', [
            'controller_name' => 'PlateformeController',
        ]);
    }
}
