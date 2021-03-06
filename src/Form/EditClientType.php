<?php
namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditClientType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class,[
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
            ->add('email', EmailType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('tel', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control']
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);    }
}