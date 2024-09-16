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
use App\Entity\Ville;
use App\Form\VilleType;

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
    public function addCentre(Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
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

    #[Route('/CentreRelaisColis/ville/add', name: 'app_centre_relais_colis_ville_add')]
    public function addVille(Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        $entite = new Ville();

        $form = $this->createForm(VilleType::class, $entite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entite);
            $manager->flush();

            $this->addFlash('success', 'Nouvelle ligne ajoutée avec succès.');

            return $this->redirectToRoute('app_centre_relais_colis');
        }

        return $this->render('centre_relais_colis/addVille.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/CentreRelaisColis/localisation/{id}', name: 'app_centre_relais_colis_localisation')]
    public function localisation(Ville $ville, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        if (!$ville) {
            throw $this->createNotFoundException('Ville non trouvée');
        }

        return $this->render('centre_relais_colis/localisation.html.twig',[
            'ville'=>$ville
        ]);
    }
}
