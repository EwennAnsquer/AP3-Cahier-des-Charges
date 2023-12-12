<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\CompteUtilisateur;
use App\Entity\Pays;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeModifyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('leCompteUtilisateur', EntityType::class, [
            //     'class' => CompteUtilisateur::class,
            //     'choice_label' => 'email',
            //     'label' => 'Compte Utilisateur',
            // ])
            ->add('PrenomAcheteur')
            ->add('NomAcheteur')
            ->add('NumeroTelephone')
            ->add('Volume')
            ->add('poids')
            ->add('DateLivraison', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('etat')
            ->add('adresse')
            ->add('laVille', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'label' => 'Ville',
            ])
            ->add('lePays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'label' => 'Pays',
            ])
            ->add('save',SubmitType::class,['label'=>'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
