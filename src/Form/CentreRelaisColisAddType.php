<?php

namespace App\Form;

use App\Entity\CentreRelaisColis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CentreRelaisColisAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse')
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'label' => 'Ville',
                //'data' => $options['selectTypeNotification']
            ])
            ->add('Nom')
            ->add('save',SubmitType::class,['label'=>'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CentreRelaisColis::class,
        ]);
    }
}
