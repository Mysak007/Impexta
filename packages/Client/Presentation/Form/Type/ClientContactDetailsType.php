<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use Impexta\Client\Presentation\Form\Model\ClientContactDetailsModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientContactDetailsType extends AbstractType
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
                EmailType::class,
                [
                    'label' => 'Email',
                ]
            )
            ->add(
                'phone',
                TelType::class,
                [
                    'label' => 'Telefonní číslo',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientContactDetailsModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_contact_details_';
    }
}
