<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Presentation\Form\Model\AdminUserModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AdminUserType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Hesla se neshodují.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'first_options' => ['label' => 'Heslo'],
                    'second_options' => ['label' => 'Heslo znovu'],
                    'required' => $options['password_required'],
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Přihlašovací jméno',
                    'validation_groups' => 'registration',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Jméno',
                ]
            )
            ->add(
                'surname',
                TextType::class,
                [
                    'label' => 'Příjmení',
                ]
            )
            ->add(
                'role',
                EnumType::class,
                [
                    'enum_class' => UserRole::class,
                    'label' => 'Role',
                    'mapped' => false,
                ]
            )
            ->add(
                'enabled',
                ChoiceType::class,
                [
                    'label' => 'Aktivní',
                    'choices' => [
                        'ano' => 1,
                        'ne' => 0,
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => AdminUserModel::class,
                'password_required' => false,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'admin_user_';
    }
}
