<?php

namespace App\Controller;

use App\Repository\CompteUtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/adminUpgrade/{id}', name: 'app_admin_Upgrade')]
    public function adminUpgrade(int $id, CompteUtilisateurRepository $compteUtilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_rapports');
        }    
        $user = $compteUtilisateurRepository->find($id);
        $user->setRoles(['ROLE_ADMIN']);

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("app_rapports");
    }
}
