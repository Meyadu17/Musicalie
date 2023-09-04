<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Departement;
use App\Entity\Festival;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('lieu')
            ->add('affiche')
            ->add('departement', EntityType::class,[
                'class' => Departement::class,
                'choice_label' => 'nom'
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text'])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text'])
            ->add('artistes', EntityType::class,[
                'class' => Artiste::class,
                'choice_label' => 'nomScene',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Festival::class,
        ]);
    }
}
