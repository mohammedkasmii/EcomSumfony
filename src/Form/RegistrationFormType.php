<?php

declare(strict_types=1);

namespace App\Form;

use App\Account\DTO\RegistrationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(child: 'name', type: TextType::class, options: [
                'label' => 'Full Name',
                'attr'  => ['placeholder' => 'Enter your full name'],
                'constraints' => [
                    new NotBlank(message: 'Please enter your name'),
                    new Length(min: 2, max: 100),
                ],
            ])
            ->add(child: 'email', type: EmailType::class, options: [
                'label' => 'Email address',
                'attr'  => ['placeholder' => 'Enter your email'],
                'constraints' => [
                    new NotBlank(message: 'Please enter your email'),
                    new Email(message: 'Please enter a valid email'),
                ],
            ])
            ->add(child: 'plainPassword', type: RepeatedType::class, options: [
                'type'   => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                    'attr'  => ['placeholder' => 'Create a password'],
                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'attr'  => ['placeholder' => 'Confirm your password'],
                ],
                'invalid_message' => 'The password fields must match.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationRequest::class,
            'attr' => [
                'novalidate' => true,
            ],
        ]);
    }
}
