<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Inquiry\Presentation\Form\Model\InquiryCreateOrderModel;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryCreateOrderType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'shipment',
                EnumType::class,
                [
                    'label' => 'Způsob dopravy',
                    'enum_class' => ShippingMethod::class,
                ]
            )->add(
                'payment',
                EnumType::class,
                [
                    'label' => 'Způsob platby',
                    'enum_class' => PaymentMethod::class,
                ]
            )
            ->add(
                'itemOffers',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => false,
                    'entry_type' => InquiryItemOfferOrderType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryCreateOrderModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_create_order_';
    }
}
