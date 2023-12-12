<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Form\SettingsType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CentreRelaisColisRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeNotificationRepository;

class ParametreController extends AbstractController
{
    #[Route('/parametre', name: 'app_parametre')]
    public function index(Request $request, CompteUtilisateurRepository $c, CentreRelaisColisRepository $ce, EntityManagerInterface $e, TypeNotificationRepository $t): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $user=$c->find($user);

        $form = $this->createForm(SettingsType::class, $user, [
            'selectTypeNotification' => $user->getLeTypeNotification(),
            //'selectCentreRelais' => $user->getIdCentreRelaisDefaut()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $e;
            $user=$c->find($this->getUser());
            $idNotif = $form->get('leTypeNotification')->getData();
            $idCentreRelais = $form->get('leCentreRelaisColisDefaut')->getData();
            $user->setLeTypeNotification($t->find($idNotif));
            if($idCentreRelais!=null){
                $user->setLeCentreRelaisColisDefaut($idCentreRelais);
            }
            //dd('test');
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to a success page or do something else
            return $this->redirectToRoute('app_parametre');
        }

        return $this->render('parametre/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
