<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;

class RapportsController extends AbstractController
{
    #[Route('/rapports', name: 'app_rapports')]
    public function index(CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        return $this->render('rapports/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/', name: 'app_redirect')]
    public function redirectToRapports(): Response
    {
         return $this->redirectToRoute('app_rapports');
    }
}
