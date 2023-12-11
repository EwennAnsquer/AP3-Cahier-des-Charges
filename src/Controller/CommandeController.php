<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Form\CommandeAddType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }
        return $this->render('commande/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/commande/add', name: 'app_commande_add')]
    public function add(Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $commande = new Commande();

        $form = $this->createForm(CommandeAddType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setEtat("en préparation");
            $commande->setLeCompteUtilisateur($user);
            $e->persist($commande);
            $e->flush();

            $this->addFlash('success', 'Nouvelle ligne ajoutée avec succès.');

            return $this->redirectToRoute('app_commande');
        }

        return $this->render('commande/add.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
