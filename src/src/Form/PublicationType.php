<?php
namespace App\Form;

use App\Entity\CarBrand;
use App\Entity\CarModel;
use App\Entity\MotorizationType;
use App\Entity\Publication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\All;
use Doctrine\ORM\EntityManagerInterface;

class PublicationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'EUR',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('year', IntegerType::class, [
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('brand', EntityType::class, [
                'class' => CarBrand::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a brand',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_brand'],
            ])
            ->add('model', EntityType::class, [
                'class' => CarModel::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a model',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_model'],
            ])
            ->add('motorizationType', EntityType::class, [
                'class' => MotorizationType::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a motorisation type',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('mileage', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('fuelType', ChoiceType::class, [
                'choices' => [
                    'Diesel' => 'diesel',
                    'Gasoline' => 'gasoline',
                    'Electric' => 'electric',
                    'Hybrid' => 'hybrid',
                ],
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('gearbox', ChoiceType::class, [
                'choices' => [
                    'Manual' => 'manual',
                    'Automatic' => 'automatic',
                ],
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('engineSize', NumberType::class, [
                'required' => false,
                'scale' => 1,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('hasWarranty', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'h-4 w-4 rounded border-gray-300'],
            ])
            ->add('warrantyMonths', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('sellerLocation', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('condition', ChoiceType::class, [
                'choices' => [
                    'New' => 'new',
                    'Used' => 'used',
                ],
                'empty_data' => 'used',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('equipment', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => ['class' => 'w-full'],
            ])
            ->add('images', FileType::class, [
                'label' => 'Images (PNG, JPG, JPEG, WEBP files)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '200000k',
                                'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Maximum size is {{ limit }} {{ suffix }}.',
                                'mimeTypes' => [
                                    'image/png',
                                    'image/jpg',
                                    'image/jpeg',
                                    'image/webp',
                                ],
                                'mimeTypesMessage' => 'Please upload a valid Image',
                            ])
                        ],
                    ]),
                ],
            ])
            ->add('video', FileType::class, [
                'label' => 'Video (MP4 file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '50000k',
                        'mimeTypes' => [
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid MP4 video',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}