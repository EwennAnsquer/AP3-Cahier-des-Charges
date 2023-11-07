<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }
        return $this->render('client/index.html.twig', [
            'user' => $user,
        ]);
    }
}
