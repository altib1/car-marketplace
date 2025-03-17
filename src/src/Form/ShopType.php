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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ShopType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Shop Name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateUniqueName']),
                ],
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
                'required' => true,
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
                'html5' => true,
                'empty_data' => new \DateTime(),
                'attr' => [
                    'class' => 'datepicker',
                    'required' => 'required',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a creation date',
                    ]),
                ],
                'invalid_message' => 'Please enter a valid date.',
                'error_bubbling' => false,
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



            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                if (empty($data['creationDate'])) {
                    $data['creationDate'] = date('Y-m-d'); // Today's date
                    $event->setData($data);
                }
            });
    }

    public function validateUniqueName($value, ExecutionContextInterface $context)
    {
        $shop = $context->getRoot()->getData();
        $shopId = $shop->getId();

        $existingShop = $this->entityManager
            ->getRepository(Shop::class)
            ->findOneBy(['name' => $value]);

        // If we found a shop with this name and it's not the current shop being edited
        if ($existingShop && $existingShop->getId() !== $shopId) {
            $context->buildViolation('A shop with this name already exists.')
                ->atPath('name')
                ->addViolation();
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
            'validation_groups' => ['Default'],
        ]);
    }
}
