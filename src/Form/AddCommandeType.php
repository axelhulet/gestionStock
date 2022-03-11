<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('client', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function(ClientRepository $repo){
                return $repo->createQueryBuilder('d')
                    ->where('d.deleted = false');
                },
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
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
