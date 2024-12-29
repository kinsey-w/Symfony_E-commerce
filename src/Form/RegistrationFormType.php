<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Last Name',
                'translation_domain' => 'messages',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'registration.error.last_name_not_blank',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'registration.error.last_name_length',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'First Name',
                'translation_domain' => 'messages',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'registration.error.first_name_not_blank',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'registration.error.first_name_length',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'translation_domain' => 'messages',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'registration.error.email_not_blank',
                    ]),
                    new Assert\Email([
                        'message' => 'registration.error.email_invalid',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'translation_domain' => 'messages',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'registration.error.password_not_blank',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'registration.error.password_min_length',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
