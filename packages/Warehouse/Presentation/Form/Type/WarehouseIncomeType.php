<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseIncomeModel;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WarehouseIncomeType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'documentId',
                TextType::class,
                [
                    'label' => 'Číslo dokumentu',
                    'required' => true,
                ]
            )
            ->add(
                'warehouse',
                EnumType::class,
                [
                    'label' => 'Sklad',
                    'enum_class' => Warehouse::class,
                ]
            )
            ->add(
                'internalCode',
                TextType::class,
                [
                    'label' => 'Kód',
                    'required' => true,
                ]
            )
            ->add(
                'date',
                DatePickerType::class,
                [
                    'label' => 'Datum',
                    'invalid_message' => 'Zadejte prosím datum ve formátu: dd.MM.yyyy',
                    'required' => true,
                ]
            )
            ->add(
                'note',
                TextareaType::class,
                [
                    'label' => 'Poznámka',
                    'required' => false,
                ]
            )
            ->add(
                'warehouseProducts',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => false,
                    'entry_type' => WarehouseProductType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'attr' => [
                        'class' => 'warehouseProduct',
                    ],
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WarehouseIncomeModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'warehouse_income_';
    }
}
