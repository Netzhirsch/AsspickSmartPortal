<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles',ChoiceType::class,[
                'label' => 'Rechte',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Benutzer' => 'ROLE_USER'
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Passwort',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ihr Passwort muss mindesten {{ limit }} Zeichen enthalten.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'required' => false
            ])
            ->add('email',EmailType::class,[
                'label' => 'E-Mail'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'speichern'
            ])
            ->add('isVerified', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'aktiviert' => true,
                    'deaktiviert' => false
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
