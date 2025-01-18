<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\All;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Shop Name',
                'required' => true,
            ])
            ->add('backgroundImageFileName', FileType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '10024k',
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            
            ->add('logoImageFileName', FileType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '10024k',
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('creationDate', DateType::class, [
                'label' => 'Creation Date',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
            ])
            ->add('services', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => ['class' => 'w-full'],
            ])
            ->add('workHours', TextType::class, [
                'label' => 'Work Hours',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
