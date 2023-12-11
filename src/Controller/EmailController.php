<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\CompteUtilisateur;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(Request $request, UrlGeneratorInterface $urlGeneratorInterface): Response
    {
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
        $mail->addAddress('destinataire@example.com', 'Nom du destinataire');

        // Définir le sujet du mail
        $mail->Subject = 'Sujet du mail';

        // Corps du mail au format HTML
        $mail->msgHTML('<p>Ceci est le corps du message au format HTML.</p>');

        // Ajouter une pièce jointe (facultatif)
        //$mail->addAttachment('chemin/vers/fichier.pdf');

        // Envoyer le mail
        if ($mail->send()) {
            $msg= 'Le message a été envoyé avec succès.';
        } else {
            $msg= 'Erreur lors de l\'envoi du message : ' . $mail->ErrorInfo;
        }
        return $this->render('email/index.html.twig', [
            'msg'=>$msg
        ]);
    }
}
