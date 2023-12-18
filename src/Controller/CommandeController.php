<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\Commande;
use App\Entity\LocalisationColis;
use App\Form\ColisModifyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteUtilisateurRepository;
use App\Form\CommandeAddType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeRepository;
use App\Repository\EtatRepository;
use App\Repository\LocalisationRepository;
use DateTime;
use PHPMailer\PHPMailer;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CompteUtilisateurRepository $c, CommandeRepository $commandeRepository): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $allCommande = $commandeRepository->findAll();

        return $this->render('commande/index.html.twig', [
            'user' => $user,
            'commandes'=> $allCommande
        ]);
    }

    #[Route('/commande/add', name: 'app_commande_add')]
    public function add(Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e, LocalisationRepository $localisationRepository, EtatRepository $etatRepository): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $commande = new Commande();

        $form = $this->createForm(CommandeAddType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('NumeroTelephone')->getData();

            if (preg_match('/^\d{10}$/', $data)) { //vérifie si NumeroTelephone contient 10 chiffres
                $localisationColis = new LocalisationColis();
                $localisationColis->setLaCommande($commande);
                $localisationColis->setLaLocalisation($localisationRepository->findBy(['nom'=>"entrepôt"])[0]);
                $localisationColis->setDate(new DateTime());
                $e->persist($localisationColis);

                $commande->setEtat($etatRepository->findBy(['nom'=>"en préparation"])[0]);
                $commande->setNumeroSuivi($this->generateTrackingNumber());
                $commande->setLeCompteUtilisateur($user);
                $e->persist($commande);
                $e->flush();

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
                $mail->addAddress($c->find($user)->getEmail(), $commande->getNomAcheteur()." ".$commande->getPrenomAcheteur());

                // Définir le sujet du mail
                $mail->Subject = "Commande reussie";

                // Corps du mail au format HTML
                $mail->msgHTML('
                    <p>Merci d\'avoir passé commande.</p>
                    <p>Votre numéro de suivi de colis est le suivant: '.$commande->getNumeroSuivi().'</p>
                ');

                // Ajouter une pièce jointe (facultatif)
                //$mail->addAttachment('chemin/vers/fichier.pdf');

                // Envoyer le mail
                $mail->send();

                $this->addFlash('success', 'Nouvelle ligne ajoutée avec succès.');

                return $this->redirectToRoute('app_commande');
            }else {
                $this->addFlash('error', 'Le numéro de téléphone doit contenir exactement 10 chiffres.');
            }
        }

        return $this->render('commande/add.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    private function generateTrackingNumber() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 13;
        
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $randomString;
    }

    #[Route('/commande/modify/{id}', name: 'app_commande_modify')]
    public function modify(Commande $commande, Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $form = $this->createForm(CommandeAddType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('NumeroTelephone')->getData();

            if (preg_match('/^\d{10}$/', $data)) { //vérifie si NumeroTelephone contient 10 chiffres
                $e->persist($commande);
                $e->flush();
    
                $this->addFlash('success', 'La ligne a été modifié avec succès.');
    
                return $this->redirectToRoute('app_commande');
            }else {
                $this->addFlash('error', 'Le numéro de téléphone doit contenir exactement 10 chiffres.');
            }
        }

        return $this->render('commande/modify.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/delete/{id}', name: 'app_commande_delete')]
    public function delete(Commande $entite,Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
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

    #[Route('/commande/colis/{id}', name: 'app_commande_colis')]
    public function colis(Commande $commande, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        $allColis = $commande->getLesColis();

        return $this->render('commande/colis.html.twig', [
            'colis' => $allColis
        ]);
    }

    #[Route('/commande/colis/modify/{id}', name: 'app_commande_colis_modify')]
    public function modifyColis(Colis $colis, Request $request, CompteUtilisateurRepository $c, EntityManagerInterface $e, CompteUtilisateurRepository $compteUtilisateurRepository): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }else{
            $user = $this->getUser();
        }

        $ancienColis = clone $colis;

        $form = $this->createForm(ColisModifyType::class, $colis);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $e->persist($colis);
                $e->flush();
    
                $this->addFlash('success', 'La ligne a été modifié avec succès.');

                if($colis->getLaCommande()->getLeCompteUtilisateur()->getLeTypeNotification()->getNom() == "email" && $this->compareColisEtat($ancienColis, $colis) === false){
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
                    $mail->Subject = 'Notification Etat Colis';

                    // Corps du mail au format HTML
                    $mail->msgHTML('
                        <p>C\'est la notification.</p>
                        <p>Votre colis est passé à l\'état '.$colis->getEtat()->getNom().'</p>
                    ');

                    $mail->send();
                }
    
                return $this->redirectToRoute('app_commande_colis',[
                    'id' => $colis->getId()
                ]);
        }

        return $this->render('commande/modifyColis.html.twig',[
            'form' => $form->createView(),
            'id' => $colis->getId()
        ]);
    }

    //si l'ancien et le nouveau colis ont les mêmes état alors renvoyer true sinon renvoyer false
    private function compareColisEtat(Colis $ancienColis, Colis $nouveauColis) 
    {
        if($ancienColis->getEtat()->getNom() == $nouveauColis->getEtat()->getNom()){
            return true;
        }else{
            return false;
        }
    }

    #[Route('/commande/colis/delete/{id}', name: 'app_commande_colis_delete')]
    public function deleteColis(Colis $entite,Request $request, EntityManagerInterface $manager, CompteUtilisateurRepository $c): Response
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

    #[Route('/commande/colis/localisation/{id}', name: 'app_commande_colis_localisation')]
    public function commandeColisLocalisation(Colis $entite, CompteUtilisateurRepository $c): Response
    {
        if ($this->getUser()==false or $c->find($this->getUser())->isIsRegister()==false) {
            return $this->redirectToRoute('app_login');
        }

        if (!$entite) {
            throw $this->createNotFoundException('Entité non trouvée');
        }
        
        return $this->render('commande/colisLocalisation.html.twig',[
            'colis'=>$entite
        ]);
    }
}
