<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseOrderModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WarehouseOrderType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'warehouse',
                EnumType::class,
                [
                    'label' => 'Sklad',
                    'enum_class' => Warehouse::class,
                ]
            )
            ->add(
                'warehouseOrderItems',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => WarehouseOrderItemType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'attr' => [
                        'class' => 'warehouseOrderItem',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WarehouseOrderModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'warehouse_order_';
    }
}
