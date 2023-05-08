<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Type;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseProductModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Microshop\SymfonySurvivalKit\Money\Form\DataTransformer\FloatToMoneyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WarehouseProductType extends AbstractType
{
    private FloatToMoneyTransformer $floatToMoneyTransformer;
    private ProductRepository $productRepository;

    public function __construct(
        FloatToMoneyTransformer $floatToMoneyTransformer,
        ProductRepository $productRepository
    ) {
        $this->floatToMoneyTransformer = $floatToMoneyTransformer;
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
                    'required' => true,
                    'choice_label' => static function (Product $product) {
                        return $product->getName();
                    },
                    'choices' => $this->productRepository->findBy([], [
                        'name' => 'ASC',
                    ]),
                ]
            )
            ->add(
                'purchasePrice',
                NumberType::class,
                [
                    'required' => true,
                    'label' => 'Cena',
                ]
            );

        $builder
            ->get('purchasePrice')
            ->addModelTransformer($this->floatToMoneyTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WarehouseProductModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'warehouse_product_';
    }
}
