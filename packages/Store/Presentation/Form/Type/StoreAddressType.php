<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Type;

use DobryProgramator\SmartformBundle\Form\Type\SmartformWholeAddressType;
use Impexta\Store\Presentation\Form\Model\StoreAddressModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StoreAddressType extends AbstractType
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
                SmartformWholeAddressType::class,
                [
                    'label' => 'Adresa',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => StoreAddressModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'store_address_';
    }
}
