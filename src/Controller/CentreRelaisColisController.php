<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CentreRelaisColis;
use App\Repository\CentreRelaisColisRepository;

class CentreRelaisColisController extends AbstractController
{
    #[Route('/CentreRelaisColis', name: 'app_centre_relais_colis')]
    public function index(CentreRelaisColisRepository $centreRelaisColisRepository): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $allCentreRelaisColis = $centreRelaisColisRepository->findAll();

        return $this->render('centre_relais_colis/index.html.twig', [
            'user' => $user,
            'centreRelaisColis' => $allCentreRelaisColis,
        ]);
    }

    #[Route('/CentreRelaisColis/modify/{id}', name: 'app_centre_relais_colis_modify')]
    public function modify(CentreRelaisColis $centreRelaisColis): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        return $this->render('centre_relais_colis/modify.html.twig', [
            'user' => $user,
            'leCentreRelaisColis' => $centreRelaisColis,
        ]);
    }

    #[Route('/CentreRelaisColis/delete/{id}', name: 'app_centre_relais_colis_delete')]
    public function delete(CentreRelaisColis $centreRelaisColis): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }


        return $this->render('centre_relais_colis/delete.html.twig', [
            'user' => $user,
            'leCentreRelaisColis' => $centreRelaisColis,
        ]);
    }
}
