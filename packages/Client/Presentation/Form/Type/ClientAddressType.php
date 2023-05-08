<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use DobryProgramator\SmartformBundle\Form\Type\SmartformWholeAddressType;
use Impexta\Client\Presentation\Form\Model\ClientAddressModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientAddressType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název adresy',
                ]
            )
            ->add(
                'address',
                SmartformWholeAddressType::class,
                [
                    'label' => 'Adresa',
                    'class' => $options['class'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientAddressModel::class,
                'class' => 'default',
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_address_';
    }
}
