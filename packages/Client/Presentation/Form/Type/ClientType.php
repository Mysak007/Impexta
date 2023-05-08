<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use App\Eshop\Enum\Country;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientType extends AbstractType
{
    public const BILLING_ADDRESS = 'billingAddress';
    public const SHIPPING_ADDRESS = 'shippingAddress';

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'personalDetails',
                ClientPersonalDetailsType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'contactDetails',
                ClientContactDetailsType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'bankAccount',
                ClientBankAccountType::class,
                [
                    'label' => false,
                    'required' => false,
                ]
            )
            ->add(
                'billingAddress',
                ClientBillingAddressType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'shippingAddress',
                ClientShippingAddressType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'clientGroup',
                EnumType::class,
                [
                    'enum_class' => ClientGroup::class,
                    'label' => 'Skupina',
                ]
            )
            ->add(
                'currency',
                ChoiceType::class,
                [
                    'label' => 'Měna',
                    'choices' => array_flip($options['currencies']),
                ]
            )
            ->add(
                'country',
                EnumType::class,
                [
                    'enum_class' => Country::class,
                    'label' => 'Země',
                    'choice_attr' => static function (Country $country) {
                        return ['data-code' => Country::getCode($country)];
                    },
                ]
            )
            ->add(
                'logo',
                FileType::class,
                [
                    'label' => 'Logo',
                    'required' => false,
                ]
            )
            ->add(
                'sale',
                IntegerType::class,
                [
                    'label' => 'Sleva',
                    'data' => 0,
                ]
            )
            ->add(
                'note',
                TextType::class,
                [
                    'label' => 'Poznámka',
                    'required' => false,
                ]
            )
            ->add(
                'clientCars',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => ClientCarType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'attr' => [
                        'class' => 'clientCar',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientModel::class,
                'currencies' => ['CZK' => 'Kč','EUR' => '€'],
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_';
    }
}
