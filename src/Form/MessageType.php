<?php

namespace App\Form;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function  buildForm(FormBuilderInterface $builder, array $options)
{
    // les champs contenu dans le formulaire
    $builder
        ->add('name', TextType::class, [
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
        ])
        ->add('email', EmailType::class, [
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
        ])
        ->add('message', TextareaType::class, [
            'required'=> true,
            'attr' =>  [ 'class' => 'form-control']
        ]);
}
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            // le nom de la classe liée au formulaire
            ['data_class' => Message::class]
//            'csrf_protection' => false
        );
    }
}