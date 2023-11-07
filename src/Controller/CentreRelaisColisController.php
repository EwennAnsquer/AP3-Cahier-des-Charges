<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CentreRelaisColisController extends AbstractController
{
    #[Route('/centre/relais/colis', name: 'app_centre_relais_colis')]
    public function index(): Response
    {
        return $this->render('centre_relais_colis/index.html.twig', [
            'controller_name' => 'CentreRelaisColisController',
        ]);
    }
}
