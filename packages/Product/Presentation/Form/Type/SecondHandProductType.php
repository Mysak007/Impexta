<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Product\Domain\Enum\VatRate;
use Impexta\Product\Presentation\Form\Model\SecondHandProductModel;
use Microshop\SymfonySurvivalKit\Money\Form\MoneyWithCurrencyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SecondHandProductType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param array<mixed, mixed> $options
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
                'perex',
                TextType::class,
                [
                    'label' => 'Úvod',
                    'required' => false,
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'label' => 'Popis',
                    'required' => false,
                ]
            )
            ->add(
                'price',
                MoneyWithCurrencyType::class,
                [
                    'label' => 'Cena',
                    'currencies' => ['CZK' => 'Kč', 'EUR' => '€'],
                ]
            )
            ->add(
                'vatRate',
                EnumType::class,
                [
                    'enum_class' => VatRate::class,
                    'label' => 'Daňová sazba',
                ]
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => SecondHandProductImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options' => [
                        'attr' => [
                            'class' => 'secondHandProductImage',
                        ],
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => SecondHandProductModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'secondhand_product_';
    }
}
