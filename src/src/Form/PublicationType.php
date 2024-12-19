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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

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
                'attr' => ['class' => 'w-full p-3 border rounded-lg', 'id' => 'publication_motorizationType'],
            ])
            ->add('brochure', FileType::class, [
                'label' => 'Brochure (IMAGE file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
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