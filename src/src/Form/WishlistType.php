<?php

namespace App\Form;

use App\Entity\Wishlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WishlistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Add form fields if needed
            // The controller suggests we don't need any direct input fields
            // as publications are added/removed via dedicated routes
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wishlist::class,
        ]);
    }
}