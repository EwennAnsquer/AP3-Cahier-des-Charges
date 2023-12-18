<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Repository\NotificationRepository;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(CompteUtilisateurRepository $c, NotificationRepository $n): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        if ($c->find($this->getUser())->getLeTypeNotification()->getNom() != "application") {
            return $this->redirectToRoute('app_rapports');
        }

        $allNotification = $n->findAll();

        return $this->render('notification/index.html.twig', [
            'user' => $user,
            "notifications" => $allNotification
        ]);
    }
}
