<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use PHPMailer\PHPMailer;
use App\Form\RegisterEmailType;
use App\Repository\CompteUtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\CallbackTransformer;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        if ($this->getUser()==true) {
            return $this->redirectToRoute('app_rapports');
        }

        $user = new CompteUtilisateur();
        $user->setIsregister(false);
        $user->setRegisterNumber(mt_rand(100000000,999999999));
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            
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
            $mail->addAddress($user->getEmail());

            // Définir le sujet du mail
            $mail->Subject = 'Registration';

            // Corps du mail au format HTML
            $mail->msgHTML('
            <p>C\'est la registration.</p>
            <p>Voici votre code:'.$user->getRegisterNumber().'</p>
            <p>Puis <a href="'.$urlGenerator->generate('app_registerEmail').'">cliquez-ici</a></p>
            ');

            $mail->send();

            return $this->redirectToRoute('app_rapports');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/registerEmail', name: 'app_registerEmail')]
    public function registerEmail(Request $request, EntityManagerInterface $entityManager, CompteUtilisateurRepository $compteUtilisateurRepository): Response
    {
        if ($this->getUser() == true) {
            return $this->redirectToRoute('app_rapports');
        }
    
        $form = $this->createForm(RegisterEmailType::class);
    
        $form->handleRequest($request);
    
        if ($form->getData() && $form->isSubmitted()) {
    
            $user = $compteUtilisateurRepository->findOneBy([
                'email' => $form->get('email')->getData(),
                'registerNumber' => $form->get('registerNumber')->getData(),
            ]);
    
            if ($user) {
                $user->setIsregister(true);
                $entityManager->flush();
                return $this->redirectToRoute('app_rapports');
            } else {
                // Add a custom error message to the email field
                $form->get('email')->addError(new FormError('This email does not exist or the verification code is incorrect.'));
            }
        }

        return $this->render('registration/registerEmail.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
