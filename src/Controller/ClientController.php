<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CompteUtilisateur;
use App\Repository\CompteUtilisateurRepository;

class ClientController extends AbstractController
{
    #[Route('/Client', name: 'app_client')]
    public function index(CompteUtilisateurRepository $compteUtilisateurRepository): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $allCompteUtilisateur = $compteUtilisateurRepository->findAll();

        return $this->render('client/index.html.twig', [
            'user' => $user,
            'compteUtilisateur' => $allCompteUtilisateur,
        ]);
    }

    #[Route('/Client/Commandes/{id}', name: 'app_client_commande')]
    public function commandes(CompteUtilisateur $compteUtilisateur): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        return $this->render('client/commande.html.twig', [
            'user' => $user,
            'compteUtilisateur' => $compteUtilisateur,
        ]);
    }

    #[Route('/Client/Commandes/Colis/{id}', name: 'app_client_colis')]
    public function colis(Commande $commande): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        return $this->render('client/colis.html.twig', [
            'user' => $user,
            'commande' => $commande,
        ]);
    }
}
