<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CentreRelaisColisController extends AbstractController
{
    #[Route('/CentreRelaisColis', name: 'app_centre_relais_colis')]
    public function index(): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }
        return $this->render('centre_relais_colis/index.html.twig', [
            'user' => $user,
        ]);
    }
}
