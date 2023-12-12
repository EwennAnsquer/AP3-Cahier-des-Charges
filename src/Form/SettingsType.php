<?php

namespace App\Form;

use App\Entity\CentreRelaisColis;
use App\Entity\CompteUtilisateur;
use App\Entity\TypeNotification;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            //  ->add('idCentreRelaisDefaut', EntityType::class, [
            //     'class' => CentreRelaisColis::class,
            //     'choice_label' => 'nom',
            //     'required'=>false,
            //     'choice_value' => 'id',
            //     'label' => 'Centre de Relais par defaut',
            //     'data' => $options['selectCentreRelais']
            //  ])
            //voir dans ap-slam > dossier a mon nom pour trouver peut-être une solution 

            ->add('leCentreRelaisColisDefaut', EntityType::class, [
                'class' => CentreRelaisColis::class,
                'choice_label' => 'nom',
                'label' => 'Centre Relais Colis par defaut',
                //'data' => $options['selectTypeNotification']
            ])

            ->add('leTypeNotification', EntityType::class, [
                'class' => TypeNotification::class,
                'choice_label' => 'nom',
                'label' => 'Type de Notification',
                'data' => $options['selectTypeNotification']
            ])
            ->add('save',SubmitType::class,['label'=>'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompteUtilisateur::class,
            'selectTypeNotification' => null,
            //'selectCentreRelais' => null,
        ]);

        $resolver->setAllowedTypes('selectTypeNotification', ['null', TypeNotification::class]);
        //$resolver->setAllowedTypes('selectCentreRelais', ['null', CentreRelaisColis::class]);
    }
}
