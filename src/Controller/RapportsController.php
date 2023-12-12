<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Repository\ColisRepository;
use DateTime;
use PHPMailer\PHPMailer;

class RapportsController extends AbstractController
{
    #[Route('/rapports', name: 'app_rapports')]
    public function index(CompteUtilisateurRepository $c, ColisRepository $colisRepository): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $this->envoiMailSiColisPasRecup($colisRepository, $user, $c);

        return $this->render('rapports/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/', name: 'app_redirect')]
    public function redirectToRapports(): Response
    {
         return $this->redirectToRoute('app_rapports');
    }

    private function envoiMailSiColisPasRecup($c, $user, $compteUtilisateurRepository){
        $actualDate = new DateTime();
        foreach ($c->findAll() as $key => $value) {
            $colis = $c->find($value);
            if($colis->getEtat()->getNom() === "Livré" && $colis->getCasier()->getDateDebutReservation()->modify("+5 days")->format('Y-m-d') == $actualDate->format("Y-m-d") || $colis->getCasier()->getDateDebutReservation()->modify("+2 days")->format('Y-m-d') == $actualDate->format("Y-m-d")){
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
                    <p>Votre colis est disponible dans son casier à l\'adresse '.$value->getCasier()->getLeCentreRelaisColis()->getAdresse().'. Il faudrait venir le chercher.</p>
                ');

                $mail->send();
            }
        }
    }
}
