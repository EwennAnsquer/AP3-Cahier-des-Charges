<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RapportsController extends AbstractController
{
    #[Route('/rapports', name: 'app_rapports')]
    public function index(): Response
    {
        return $this->render('rapports/index.html.twig', [
            'controller_name' => 'RapportsController',
        ]);
    }
}
