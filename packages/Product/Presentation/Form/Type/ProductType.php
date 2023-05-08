<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Infrastructure\Repository\ProductCardRepository;
use Impexta\Product\Presentation\Form\Model\ProductModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductType extends AbstractType
{
    private ProductCardRepository $productCardRepository;

    public function __construct(ProductCardRepository $productCardRepository)
    {
        $this->productCardRepository = $productCardRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'productCard',
                Select2EntityType::class,
                [
                    'class' => ProductCard::class,
                    'label' => 'Produktová karta',
                    'placeholder' => 'Vyberte produktovou kartu',
                    'choices' => $this->productCardRepository->findAll(),
                    'choice_label' => static function (ProductCard $productCard) {
                        return $productCard->getName() . ' - ' . $productCard->getOriginalCode();
                    },
                ]
            )
            ->add(
                'code',
                TextType::class,
                [
                    'label' => 'Kód',
                    'required' => true,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název',
                    'required' => true,
                ]
            )
            ->add(
                'slug',
                TextType::class,
                [
                    'label' => 'Slug',
                    'required' => true,
                ]
            )
            ->add(
                'manufacturer',
                TextType::class,
                [
                    'label' => 'Výrobce',
                    'required' => true,
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                [
                    'label' => 'Váha',
                ]
            )
            ->add(
                'leastInStock',
                NumberType::class,
                [
                    'label' => 'Minimální počet na skladu',
                    'required' => false,
                ]
            )
            ->add(
                'needsExtraShipping',
                CheckboxType::class,
                [
                    'label' => 'Vyžaduje zvláštní dopravu?',
                    'required' => false,
                ]
            )
            ->add(
                'showOnEshop',
                CheckboxType::class,
                [
                    'label' => 'Zobrazit na E-shopu?',
                    'required' => false,
                ]
            )
            ->add(
                'actionProduct',
                CheckboxType::class,
                [
                    'label' => 'Produkt v akci',
                    'required' => false,
                ]
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => ProductImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options' => [
                        'attr' => [
                            'class' => 'productImage',
                        ],
                    ],
                ]
            )
            ->add(
                'uploadedImages',
                FileType::class,
                [
                    'label' => 'Hromadné nahrání obrázků',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'help' => 'Rozměry jednotlivých obrázků by měly být 450x300.',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ProductModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'product_';
    }
}
