<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Pays;

class CommandeAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lePays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'label' => 'Pays',
            ])
            ->add('PrenomAcheteur')
            ->add('NomAcheteur')
            ->add('adresse')
            ->add('laVille', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'label' => 'Ville',
            ])
            ->add('NumeroTelephone')
            ->add('Volume')
            ->add('poids')
            ->add('DateLivraison')
            ->add('DateLivraison', DateType::class, [
                'widget' => 'single_text',
                // Ajoutez d'autres options de format si nécessaire
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
