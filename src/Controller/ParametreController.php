<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParametreController extends AbstractController
{
    #[Route('/parametre', name: 'app_parametre')]
    public function index(): Response
    {
        return $this->render('parametre/index.html.twig', [
            'controller_name' => 'ParametreController',
        ]);
    }
}
