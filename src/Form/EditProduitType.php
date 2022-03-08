<?php
namespace App\Form;


use App\Entity\Client;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProduitType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class,[
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control', 'readonly'=>true]
            ])
            ->add('nom', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('desc', TextareaType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('prixNum', NumberType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            ->add('stock', IntegerType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);    }
}
