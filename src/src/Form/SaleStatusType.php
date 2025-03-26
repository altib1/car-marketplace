<?php

namespace App\Form;

use App\Entity\SaleStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sold', CheckboxType::class, [
                'label' => 'profile.publication.show.remove.sold',
                'required' => false,
            ])
            ->add('saleDate', DateTimeType::class, [
                'label' => 'profile.publication.show.remove.date',
                'widget' => 'single_text',
                'required' => false,
                'html5' => true,
                'data' => new \DateTime('now'),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SaleStatus::class,
        ]);
    }
}