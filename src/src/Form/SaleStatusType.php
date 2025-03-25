<?php

namespace App\Form;

use App\Entity\SaleStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SaleStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sold', CheckboxType::class, [
                'label' => 'profile.publication.show.remove.sold',
                'required' => false,
            ]);
        
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $sale = $event->getData();
                $form = $event->getForm();
    
                $this->addSaleFields($form, $sale?->isSold());
            });
    
            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();
    
                $this->addSaleFields($form, !empty($data['sold']));
            });
    }

    public function addSaleFields($form, $isSold): void
    {
        if ($isSold) {
            $form->add('saleDate', DateTimeType::class, [
                'label' => 'profile.publication.show.remove.date',
                'widget' => 'single_text',
                'required' => false,
                'html5' => true,
                'data' => new \DateTime('now'),
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SaleStatus::class,
        ]);
    }
}