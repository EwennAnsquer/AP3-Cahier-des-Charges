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
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('rapports/index.html.twig', [
            'controller_name' => 'RapportsController',
        ]);
    }
}
