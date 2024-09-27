<?php

namespace App\Form;

use App\Entity\Casier;
use App\Entity\CentreRelaisColis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CasierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('volume')
            ->add('leCentreRelaisColis', EntityType::class, [
                'class' => CentreRelaisColis::class,
                'choice_label' => 'Nom',
                'label' => 'Centre Relais Colis',
            ])
            ->add('save',SubmitType::class,['label'=>'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casier::class,
        ]);
    }
}
