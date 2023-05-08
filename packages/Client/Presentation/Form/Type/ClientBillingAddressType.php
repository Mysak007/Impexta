<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use Impexta\Client\Presentation\Form\Model\ClientBillingAddressModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientBillingAddressType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'address',
                ClientAddressType::class,
                [
                    'label' => false,
                    'class' => 'billingAddress',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientBillingAddressModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_';
    }
}
