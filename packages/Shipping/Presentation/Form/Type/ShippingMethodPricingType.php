<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Form\Type;

use App\Eshop\Enum\Country;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Impexta\Shipping\Presentation\Form\Model\ShippingMethodPricingModel;
use Microshop\SymfonySurvivalKit\Money\Form\MoneyWithCurrencyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShippingMethodPricingType extends AbstractType
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
                    'required' => true,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Informace o dopravě',
                    'required' => false,
                ]
            )
            ->add(
                'shippingMethod',
                EnumType::class,
                [
                    'label' => 'Doprava',
                    'enum_class' => ShippingMethod::class,
                    'disabled' => $options['is_disabled'],
                ]
            )
            ->add(
                'country',
                EnumType::class,
                [
                    'label' => 'Země',
                    'enum_class' => Country::class,
                    'disabled' => $options['is_disabled'],
                ]
            )
            ->add(
                'price',
                MoneyWithCurrencyType::class,
                [
                    'required' => true,
                    'label' => 'Cena',
                    'currencies' => ['CZK' => 'Kč', 'EUR' => '€'],
                ]
            )
            ->add(
                'overWeightLimit',
                NumberType::class,
                [
                    'required' => false,
                    'label' => 'Limit nadváhy KG',
                ]
            )
            ->add(
                'overWeightPrice',
                MoneyWithCurrencyType::class,
                [
                    'required' => true,
                    'label' => 'Cena za nadváhu',
                    'currencies' => ['CZK' => 'Kč', 'EUR' => '€'],
                ]
            )
            ->add(
                'cashOnDeliveryFee',
                MoneyWithCurrencyType::class,
                [
                    'required' => true,
                    'label' => 'Cena za dobírku',
                    'currencies' => ['CZK' => 'Kč', 'EUR' => '€'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ShippingMethodPricingModel::class,
                'is_disabled' => false,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'shipping_method_pricing_';
    }
}
