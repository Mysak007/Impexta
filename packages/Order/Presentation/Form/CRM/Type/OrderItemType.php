<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\CRM\Type;

use Impexta\Order\Presentation\Form\CRM\Model\OrderItemModel;
use Impexta\Product\Domain\Entity\Product;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Microshop\SymfonySurvivalKit\Money\Form\DataTransformer\FloatToMoneyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderItemType extends AbstractType
{
    private FloatToMoneyTransformer $floatToMoneyTransformer;

    public function __construct(
        FloatToMoneyTransformer $floatToMoneyTransformer
    ) {
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
                'product',
                Select2EntityType::class,
                [
                    'label' => 'Produkty',
                    'required' => false,
                    'class' => Product::class,
                    'placeholder' => '',
                ]
            )
            ->add(
                'quantity',
                NumberType::class,
                [
                    'label' => 'Množství',
                ]
            )
            ->add(
                'unitPrice',
                NumberType::class,
                [
                    'label' => 'Cena',
                ]
            );

        $builder
            ->get('unitPrice')
            ->addModelTransformer($this->floatToMoneyTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => OrderItemModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'order_item_';
    }
}
