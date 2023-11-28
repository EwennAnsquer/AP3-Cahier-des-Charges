<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CentreRelaisColis;
use App\Form\CentreRelaisColisAddType;
use App\Repository\CentreRelaisColisRepository;
use App\Form\CentreRelaisColisModifyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CompteUtilisateurRepository;

class CentreRelaisColisController extends AbstractController
{
    #[Route('/CentreRelaisColis', name: 'app_centre_relais_colis')]
    public function index(CentreRelaisColisRepository $centreRelaisColisRepository, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
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
    public function modify(CentreRelaisColis $centreRelaisColis, Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        $centreRelaisColisModify = $centreRelaisColis;
        $form = $this->createForm(CentreRelaisColisModifyType::class, $centreRelaisColisModify);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($centreRelaisColisModify);
            $manager->flush();

            return $this->redirectToRoute('app_centre_relais_colis');
        }

        return $this->render('centre_relais_colis/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/CentreRelaisColis/delete/{id}', name: 'app_centre_relais_colis_delete')]
    public function delete(CentreRelaisColis $entite,Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
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

    #[Route('/CentreRelaisColis/add', name: 'app_centre_relais_colis_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }

        $entite = new CentreRelaisColis();

        $form = $this->createForm(CentreRelaisColisAddType::class, $entite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entite);
            $manager->flush();

            $this->addFlash('success', 'Nouvelle ligne ajoutée avec succès.');

            return $this->redirectToRoute('app_centre_relais_colis');
        }

        return $this->render('centre_relais_colis/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
