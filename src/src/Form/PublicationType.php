<?php

namespace App\Form;

use App\Entity\CarBrand;
use App\Entity\Publication;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => ['class' => 'w-full p-3 border rounded-lg'],
        ])
        ->add('description', TextareaType::class, [
            'attr' => ['class' => 'w-full p-3 border rounded-lg'],
        ])
        ->add('price', NumberType::class, [
            'attr' => ['class' => 'w-full p-3 border rounded-lg'],
        ])
        ->add('year', NumberType::class, [
            'attr' => ['class' => 'w-full p-3 border rounded-lg'],
        ])
        ->add('brand', EntityType::class, [
            'class' => CarBrand::class,
            'choice_label' => 'id',
            'attr' => ['class' => 'w-full p-3 border rounded-lg'],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
