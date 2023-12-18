<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Repository\ColisRepository;
use DateTime;
use PHPMailer\PHPMailer;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;

class RapportsController extends AbstractController
{
    #[Route('/rapports', name: 'app_rapports')]
    public function index(CompteUtilisateurRepository $c, ColisRepository $colisRepository, EtatRepository $etatRepository, EntityManagerInterface $e): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $colis = $colisRepository->findAll();

        $colisEtat=[0,0,0,0,0,0,0];

        foreach($colis as $co){
            for ($i=1; $i < $etatRepository->count([])+1; $i++) { //+1 car décallé de 1 (l'id de la table Etat va de 1 à 7 et ne commence pas par 0)
                if($co->getEtat()->getNom() == $etatRepository->find($i)->getNom()){
                    $colisEtat[$i-1]+=1;
                }
            }
            $this->envoiMailSiColisPasRecup($user, $c, $co,$e); //le user actuel, le CompteUtilisateurRepository et le colis actuel
        }

        return $this->render('rapports/index.html.twig', [
            'user' => $user,
            'colisEtat' => $colisEtat,
        ]);
    }

    #[Route('/', name: 'app_redirect')]
    public function redirectToRapports(): Response
    {
         return $this->redirectToRoute('app_rapports');
    }

    private function envoiMailSiColisPasRecup($user, $compteUtilisateurRepository, $colis, EntityManagerInterface $e){
        $actualDate = new DateTime();
        if($colis->getEtat()->getNom() == "Livré" && ($colis->getCasier()->getDateDebutReservation()->modify("+5 days")->format('Y-m-d') == $actualDate->format("Y-m-d") || $colis->getCasier()->getDateDebutReservation()->modify("+2 days")->format('Y-m-d') == $actualDate->format("Y-m-d")) ){
            if($compteUtilisateurRepository->find($user)->getleTypeNotification()->getNom() == "application"){
                $n = new Notification();
                $n->setLeCompteUtilisateur($compteUtilisateurRepository->find($user));
                $n->setLeTypeNotification($compteUtilisateurRepository->find($user)->getleTypeNotification());
                $n->setTitre('Votre colis est disponible dans son casier à l\'adresse '.$colis->getCasier()->getLeCentreRelaisColis()->getAdresse().'. Il faudrait venir le chercher');
                $n->setDate(new DateTime());
                $e->persist($n);
                $e->flush();
            }else{
                // Créer une nouvelle instance de PHPMailer
                $mail = new PHPMailer\PHPMailer();

                // Activer le mode de débogage (0 pour désactiver)
                $mail->SMTPDebug = 0;

                // Définir le type de transport sur SMTP
                $mail->isSMTP();

                // Hôte du serveur SMTP (MailHog utilise souvent le port 1025)
                $mail->Host = 'localhost';
                $mail->Port = 1025;

                // Désactiver l'authentification SMTP (MailHog n'a généralement pas besoin d'authentification)
                $mail->SMTPAuth = false;

                // Définir l'expéditeur et le destinataire
                $mail->setFrom('no-reply@ap3-retrait-colis.com', 'AP3 Retrait Colis');

                $mail->addAddress($compteUtilisateurRepository->find($user)->getEmail());

                // Définir le sujet du mail
                $mail->Subject = 'Notification Ramassage Colis';

                // Corps du mail au format HTML
                $mail->msgHTML('
                    <p>C\'est la notification.</p>
                    <p>Votre colis est disponible dans son casier à l\'adresse '.$colis->getCasier()->getLeCentreRelaisColis()->getAdresse().'. Il faudrait venir le chercher.</p>
                ');

                $mail->send();
            }
        }
    }
}
