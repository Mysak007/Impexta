<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\CRM\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientCar;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Presentation\Form\Type\ClientShippingAddressType;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Presentation\Form\CRM\Model\OrderModel;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderType extends AbstractType
{
    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'client',
                Select2EntityType::class,
                [
                    'label' => 'Klient',
                    'class' => Client::class,
                    'choice_label' => static function (Client $client) {
                        return $client->getPersonalDetails()->getName();
                    },
                    'placeholder' => 'Vyberte zákazníka',
                    'choice_attr' => static function (Client $client) {
                        $country = $client->getCountry()->getValue();

                        return ['class' => 'country__' . $country];
                    },
                ]
            )
            ->add(
                'clientCar',
                Select2EntityType::class,
                [
                    'label' => 'Vozidla',
                    'required' => false,
                    'class' => ClientCar::class,
                    'choice_label' => static function (ClientCar $clientCar) {
                        return $clientCar->getCar();
                    },
                    'placeholder' => 'Vyberte vozidlo',
                ]
            )
            ->add(
                'shippingMethod',
                EnumType::class,
                [
                    'enum_class' => ShippingMethod::class,
                    'label' => 'Způsob dopravy',
                ]
            )
            ->add(
                'paymentMethod',
                EnumType::class,
                [
                    'enum_class' => PaymentMethod::class,
                    'label' => 'Způsob platby',
                    'choices' => [
                        'Převodem' => PaymentMethod::get(PaymentMethod::TRANSFER),
                        'Hotově' => PaymentMethod::get(PaymentMethod::CASH),
                    ],
                ]
            )
            ->add(
                'selectedShippingAddress',
                Select2EntityType::class,
                [
                    'label' => 'Vyberte doručovací adresu',
                    'class' => ClientShippingAddress::class,
                    'placeholder' => 'Vyberte adresu',
                    'required' => false,
                ]
            )
            ->add(
                'filledInShippingAddress',
                ClientShippingAddressType::class,
                [
                    'label' => 'Přidat doručovací adresu',
                    'mapped' => false,
                    'required' => false,
                ]
            )
            ->add(
                'extraSale',
                TextType::class,
                [
                    'label' => 'Sleva',
                    'required' => false,
                ]
            )
            ->add(
                'currency',
                ChoiceType::class,
                [
                    'choices' => [
                        'CZK' => 'CZK',
                        'EUR' => 'EUR',
                    ],
                    'label' => 'Měna',
                ]
            )
            ->add(
                'items',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => OrderItemType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'attr' => [
                        'class' => 'orderItem',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'warehouse_order_';
    }
}
