<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Type;

use Impexta\User\Presentation\Form\Model\ShopUserPasswordModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShopUserPasswordType extends AbstractType
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
                    'first_options' => ['label' => 'Heslo'],
                    'second_options' => ['label' => 'Heslo znovu'],
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ShopUserPasswordModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'shop_user_password';
    }
}
