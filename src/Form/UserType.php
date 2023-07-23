<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $builder->getData();

        $builder
            ->add('email', EmailType::class, [
                'required' => true
            ])
            ->add('confirmEmail', EmailType::class, [
                'required' => true,
                'mapped' => false
            ])
            ->add('firstName', TextType::class, [
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'required' => true
            ])
            ->add('city', TextType::class, [
                'required' => true
            ])
            ->add('province', TextType::class, [
                'required' => true
            ]);

        // if ($user->getId() !== null && ($user->getBecomeVendor() === null || $user->getBecomeVendor() === false)) {
        //     $builder->add('becomeVendor', RadioType::class, [
        //         'required' => false,
        //         'label' => 'Become a Vendor of the Valley',
        //     ]);
        // }

        if ($user->getId() === null) {
            $builder->add('password', PasswordType::class, [
                'required' => true
            ])
                ->add('confirmPassword', PasswordType::class, [
                    'required' => true,
                    'mapped' => false
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
