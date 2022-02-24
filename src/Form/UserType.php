<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class UserType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $builder ->add('lastname', TextType::class, [
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
        ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('birthdate', DateType::class),[

    ]
    }
}