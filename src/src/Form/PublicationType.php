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
use App\Entity\Region;
use App\Entity\Country;

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
                'label' => 'profile.publication.form.publication.description',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'profile.publication.form.publication.price',
                'currency' => 'EUR',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('year', IntegerType::class, [
                'label' => 'profile.publication.form.publication.year',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('brand', EntityType::class, [
                'label' => 'profile.publication.form.publication.brand.label',
                'class' => CarBrand::class,
                'choice_label' => 'name',
                'placeholder' => 'profile.publication.form.publication.brand.placeholder',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_brand'],
            ])
            ->add('model', EntityType::class, [
                'label' => 'profile.publication.form.publication.model.label',
                'class' => CarModel::class,
                'choice_label' => 'name',
                'placeholder' => 'profile.publication.form.publication.model.placeholder',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_model'],
            ])
            ->add('motorizationType', EntityType::class, [
                'label' => 'profile.publication.form.publication.motorization.label',
                'class' => MotorizationType::class,
                'choice_label' => 'name',
                'placeholder' => 'profile.publication.form.publication.motorization.placeholder',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('mileage', IntegerType::class, [
                'label' => 'profile.publication.form.publication.mileage',
                'required' => false,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('fuelType', ChoiceType::class, [
                'label' => 'profile.publication.form.publication.fuel_type.label',
                'choices' => [
                    'profile.publication.form.publication.fuel_type.choices.diesel' => 'diesel',
                    'profile.publication.form.publication.fuel_type.choices.gasoline' => 'gasoline',
                    'profile.publication.form.publication.fuel_type.choices.electric' => 'electric',
                    'profile.publication.form.publication.fuel_type.choices.hybrid' => 'hybrid',
                ],
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('gearbox', ChoiceType::class, [
                'label' => 'profile.publication.form.publication.gearbox.label',
                'choices' => [
                    'profile.publication.form.publication.gearbox.choices.manual' => 'manual',
                    'profile.publication.form.publication.gearbox.choices.automatic' => 'automatic',
                ],
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('engineSize', NumberType::class, [
                'label' => 'profile.publication.form.publication.engine_size',
                'required' => false,
                'scale' => 1,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('hasWarranty', CheckboxType::class, [
                'label' => 'profile.publication.form.publication.warranty.has',
                'required' => false,
                'attr' => ['class' => 'h-4 w-4 rounded border-gray-300'],
            ])
            ->add('warrantyMonths', IntegerType::class, [
                'label' => 'profile.publication.form.publication.warranty.months',
                'required' => false,
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('sellerLocation', EntityType::class, [
                'label' => 'profile.publication.form.publication.location.region.label',
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => 'profile.publication.form.publication.location.region.placeholder',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_region'],
            ])
            ->add('country', EntityType::class, [
                'label' => 'profile.publication.form.publication.location.country.label',
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'profile.publication.form.publication.location.country.placeholder',
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_country'],
            ])
            ->add('condition', ChoiceType::class, [
                'label' => 'profile.publication.form.publication.condition.label',
                'choices' => [
                    'profile.publication.form.publication.condition.choices.new' => 'new',
                    'profile.publication.form.publication.condition.choices.used' => 'used',
                ],
                'empty_data' => 'used',
                'attr' => ['class' => 'w-full p-3 border rounded-lg'],
            ])
            ->add('equipment', CollectionType::class, [
                'label' => 'profile.publication.form.publication.equipment',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => ['class' => 'w-full'],
            ])
            ->add('images', FileType::class, [
                'label' => 'profile.publication.form.publication.images.label',
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