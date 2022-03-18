<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
            ->add('updateDate', DateType::class, [
                'label_attr' => ['class' => 'form-label'],
                'widget' => 'single_text',
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
            ->add('creationdate', DateType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
            ->add('etat', EntityType::class, [
                'class' =>Etat::class,
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true],
                'disabled' => true
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'label_attr' => ['class' => 'form-label'],
                'disabled' => true,
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
