<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemRequestRepository;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemOfferModel;
use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Warehouse\Domain\Entity\WarehouseProduct;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Microshop\SymfonySurvivalKit\Money\Form\DataTransformer\FloatToMoneyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryItemOfferType extends AbstractType
{
    private ProductRepository $productRepository;
    private InquiryItemRequestRepository $inquiryItemRequestRepository;
    private WarehouseProductRepository $warehouseProductRepository;
    private FloatToMoneyTransformer $floatToMoneyTransformer;

    public function __construct(
        InquiryItemRequestRepository $inquiryItemRequestRepository,
        ProductRepository $productRepository,
        WarehouseProductRepository $warehouseProductRepository,
        FloatToMoneyTransformer $floatToMoneyTransformer
    ) {
        $this->productRepository = $productRepository;
        $this->inquiryItemRequestRepository = $inquiryItemRequestRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
        $this->floatToMoneyTransformer = $floatToMoneyTransformer;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'inquiryItemRequest',
                Select2EntityType::class,
                [
                    'label' => 'Poptávaný díl',
                    'class' => InquiryItemRequest::class,
                    'required' => true,
                    'choice_label' => static function (InquiryItemRequestInterface $inquiryItemRequest) {
                        return $inquiryItemRequest->getProductCard()->getName();
                    },
                    'choices' => $this->inquiryItemRequestRepository->findBy([], [
                        'productCard' => 'ASC',
                    ]),
                    'attr' => ['class' => 'itemOfferSelect2'],
                ]
            )
            ->add(
                'product',
                Select2EntityType::class,
                [
                    'label' => 'Nabízený díl',
                    'class' => Product::class,
                    'required' => true,
                    'choices' => $this->productRepository->findBy([], [
                        'name' => 'ASC',
                    ]),
                    'attr' => ['class' => 'itemOfferSelect2'],
                ]
            )
            ->add(
                'warehouseProduct',
                Select2EntityType::class,
                [
                    'label' => 'Skladový díl',
                    'class' => WarehouseProduct::class,
                    'required' => false,
                    'choice_label' => static function (WarehouseProductInterface $warehouseProduct) {
                        return $warehouseProduct->getProduct()->getName();
                    },
                    'choices' => $this->warehouseProductRepository->findBy([], [
                        'product' => 'ASC',
                    ]),
                    'attr' => ['class' => 'itemOfferSelect2'],
                ]
            )
            ->add(
                'price',
                NumberType::class,
                [
                    'required' => true,
                    'label' => 'Cena',
                ]
            );

        $builder
            ->get('price')
            ->addModelTransformer($this->floatToMoneyTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryItemOfferModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_item_offer_';
    }
}
