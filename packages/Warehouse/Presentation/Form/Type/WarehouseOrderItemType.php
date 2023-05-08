<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Type;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseOrderItemModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WarehouseOrderItemType extends AbstractType
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'product',
                Select2EntityType::class,
                [
                    'label' => 'Produkt',
                    'class' => Product::class,
                    'choice_label' => static function (Product $product) {
                        return $product->getName();
                    },
                    'choices' => $this->productRepository->findBy([], [
                        'name' => 'ASC',
                    ]),
                ]
            )
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => 'Množství',
                ]
            )
            ->add(
                'supplier',
                TextType::class,
                [
                    'label' => 'Dodavatel',
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WarehouseOrderItemModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'warehouse_order_item_';
    }
}
