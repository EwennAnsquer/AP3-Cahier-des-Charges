<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(): Response
    {
        if ($this->getUser()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }
        return $this->render('notification/index.html.twig', [
            'user' => $user,
        ]);
    }
}
