<?php

namespace App\Form;

use App\Entity\Warranty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WarrantyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category', ChoiceType::class, [
            'choices' => [
                'Bike' => 'Bike',
                'Car' => 'Car',
                'Console' => 'Console',
                'Earphones' => 'Earphones',
                'Keyboard' => 'Keyboard',
                'Laptop' => 'Laptop',
                'Microphone' => 'Microphone',
                'Mouse' => 'Mouse',
                'Phone' => 'Phone',
                'Printer' => 'Printer',
                'Speakers' => 'Speakers',
                'TV' => 'TV'
            ],
            'attr' => [
                'class' => 'detail',
            ],
            'label' => 'Kategoria',
        ])
        ->add('product_name', TextType::class, [
            'attr' => [
                'class' => 'detail',
                'placeholder' => 'e.g. Samsung OLED 4k 2020',
            ],
            'label' => 'Nazwa produktu',
        ])
        ->add('purchase_date', DateType::class, array(
            'widget' => 'single_text',
            'attr' => [
                'class' => 'detail',
            ],
            'label' => 'Data zakupu',
        ))
        ->add('warranty_period', IntegerType::class, [
            'attr' => [
                'class' => 'detail',
                'placeholder' => 'e.g. 5 lat',
            ],
            'label' => 'Okres gwarancji',
            
        ])
        ->add('receipt', FileType::class, [
            'attr' => [
                'class' => 'detail',
                'id' => 'file-box'
            ],
            'label' => 'Paragon',
            'required'   => false,
            'mapped' => false,
            'constraints' => [
                new Assert\File([
                    'maxSize' => '2M',
                    'mimeTypes' => ['image/svg+xml', 'image/png', 'image/jpeg'],
                    'mimeTypesMessage' => 'Invalid file format. Allowed formats: .svg, .jpg, .png.',
                ]),
               
            ],
            
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Warranty::class,
        ]);
    }
}
