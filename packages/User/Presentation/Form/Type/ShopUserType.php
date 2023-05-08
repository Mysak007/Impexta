<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Type;

use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShopUserType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'E-mail',
                    'validation_groups' => 'registration',
                ]
            )
            ->add(
                'password',
                ShopUserPasswordType::class,
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ShopUserModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'shop_user_';
    }
}
