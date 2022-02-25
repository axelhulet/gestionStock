<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('lastName', TextType::class, [
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom : ',
                'label_attr' => ['class' => 'form-label'],
                'disabled' => false,
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('birthDate', BirthdayType::class,[
                'label' => 'Date de naissance : ',
                'label_attr' => ['class' => 'form-label'],
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('title', ChoiceType::class,[
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
//                'expanded' => true,
//                'multiple' => false,
                'required' => true,
                'attr' =>  [ 'class' => 'form-select']
            ])
            ->add('file', FileType::class, [
                'required' => true,
                'constraints' => [ new File(['maxSize' => '2m', 'mimeTypes' => ['application/pdf']])
                ]
            ])
            ->add('condition', CheckboxType::class, [
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
        // le nom de la classe liée au formulaire
            ['data_class' => User::class]
        );
    }
}