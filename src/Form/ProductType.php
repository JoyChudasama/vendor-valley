<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'currency' => 'USD',
                'divisor' => 100,
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Is this product available?',
                'required' => false,
            ])
            ->add('isListed', CheckboxType::class, [
                'label' => 'Would you like to list this product for sell?',
                'required' => false,
            ])
            ->add('tempProductImages', DropzoneType::class, [
                'label' => 'Images',
                'required' => false,
                'mapped' => false,
                'multiple'=>true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
