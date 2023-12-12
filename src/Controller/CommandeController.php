<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\Commande;
use App\Form\ColisModifyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Form\CommandeAddType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeRepository;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CompteUtilisateurRepository $c, CommandeRepository $commandeRepository): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $allCommande = $commandeRepository->findAll();

        return $this->render('commande/index.html.twig', [
            'user' => $user,
            'commandes'=> $allCommande
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
            $data = $form->get('NumeroTelephone')->getData();

            if (preg_match('/^\d{10}$/', $data)) { //vérifie si NumeroTelephone contient 10 chiffres
                $commande->setEtat("en préparation");
                $commande->setLeCompteUtilisateur($user);
                $e->persist($commande);
                $e->flush();

                $this->addFlash('success', 'Nouvelle ligne ajoutée avec succès.');

                return $this->redirectToRoute('app_commande');
            }else {
                $this->addFlash('error', 'Le numéro de téléphone doit contenir exactement 10 chiffres.');
            }
        }

        return $this->render('commande/add.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/modify/{id}', name: 'app_commande_modify')]
    public function modify(Commande $commande, Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $form = $this->createForm(CommandeAddType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('NumeroTelephone')->getData();

            if (preg_match('/^\d{10}$/', $data)) { //vérifie si NumeroTelephone contient 10 chiffres
                $e->persist($commande);
                $e->flush();
    
                $this->addFlash('success', 'La ligne a été modifié avec succès.');
    
                return $this->redirectToRoute('app_commande');
            }else {
                $this->addFlash('error', 'Le numéro de téléphone doit contenir exactement 10 chiffres.');
            }
        }

        return $this->render('commande/modify.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/delete/{id}', name: 'app_commande_delete')]
    public function delete(Commande $entite,Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        if (!$entite) {
            throw $this->createNotFoundException('Entité non trouvée');
        }

        $manager->remove($entite);
        $manager->flush();

        $this->addFlash('success', 'Entité supprimée avec succès.');

        // Redirigez vers la page d'où provient la requête
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/commande/colis/{id}', name: 'app_commande_colis')]
    public function colis(Commande $commande, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        $allColis = $commande->getLesColis();

        return $this->render('commande/colis.html.twig', [
            'colis' => $allColis
        ]);
    }

    #[Route('/commande/colis/modify/{id}', name: 'app_commande_colis_modify')]
    public function modifyColis(Colis $colis, Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ColisModifyType::class, $colis);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $e->persist($colis);
                $e->flush();
    
                $this->addFlash('success', 'La ligne a été modifié avec succès.');
    
                return $this->redirectToRoute('app_commande_colis',[
                    'id' => $colis->getId()
                ]);
        }

        return $this->render('commande/modifyColis.html.twig',[
            'form' => $form->createView(),
            'id' => $colis->getId()
        ]);
    }

    #[Route('/commande/colis/delete/{id}', name: 'app_commande_colis_delete')]
    public function deleteColis(Colis $entite,Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        if (!$entite) {
            throw $this->createNotFoundException('Entité non trouvée');
        }

        $manager->remove($entite);
        $manager->flush();

        $this->addFlash('success', 'Entité supprimée avec succès.');

        // Redirigez vers la page d'où provient la requête
        return $this->redirect($request->headers->get('referer'));
    }
}
