<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Product\Presentation\Form\Model\ProductPriceModel;
use Microshop\SymfonySurvivalKit\Money\Form\MoneyWithCurrencyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductPriceType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'price',
                MoneyWithCurrencyType::class,
                [
                    'label' => 'Cena',
                    'currencies' => ['CZK' => 'Kč', 'EUR' => '€'],
                ]
            )
            ->add(
                'clientGroup',
                EnumType::class,
                [
                    'enum_class' => ClientGroup::class,
                    'label' => 'Skupina zákazníků',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ProductPriceModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'product_price_';
    }
}
