<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Form\Type;

use Impexta\Car\Presentation\Form\Model\CarManufacturerModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CarManufacturerType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název',
                ]
            )
            ->add(
                'showOnEshop',
                CheckboxType::class,
                [
                    'label' => 'Zobrazit na eshopu',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => CarManufacturerModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'car_manufacturer_';
    }
}
