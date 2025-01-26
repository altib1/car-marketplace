<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'profile.edit.form.name'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'profile.edit.form.lastname'
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'profile.edit.form.phone'
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'profile.edit.form.gender',
                'choices' => [
                    'profile.edit.form.gender_options.male' => 'male',
                    'profile.edit.form.gender_options.female' => 'female',
                    'profile.edit.form.gender_options.other' => 'other'
                ],
                'choice_translation_domain' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'messages'
        ]);
    }
}