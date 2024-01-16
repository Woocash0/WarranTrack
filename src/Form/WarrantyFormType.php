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
        ])
        ->add('product_name', TextType::class, [
            'attr' => [
                'class' => 'detail',
                'placeholder' => 'e.g. Samsung OLED 4k 2020',
            ],
        ])
        ->add('purchase_date', DateType::class, array(
            'widget' => 'single_text',
            'attr' => [
                'class' => 'detail',
            ],
        ))
        ->add('warranty_period', TextType::class, [
            'attr' => [
                'class' => 'detail',
                'placeholder' => 'e.g. 5 lat',
            ],
        ])
        ->add('receipt', FileType::class, [
            'attr' => [
                'class' => 'detail',
                'id' => 'file-box'
            ],
            'label' => 'Paragon',
            'required'   => false,
            'mapped' => false
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Warranty::class,
        ]);
    }
}
