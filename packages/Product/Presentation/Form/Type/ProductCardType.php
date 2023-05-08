<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Car\Domain\Entity\Car;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Impexta\Product\Infrastructure\Repository\ProductCategoryRepository;
use Impexta\Product\Presentation\Form\Model\ProductCardModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductCardType extends AbstractType
{
    private ProductCategoryRepository $categoryRepository;

    public function __construct(
        ProductCategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'category',
                Select2EntityType::class,
                [
                    'label' => 'Zvolte kategorii',
                    'class' => Category::class,
                    'choice_label' => static function (Category $category) {
                        return $category->getName();
                    },
                    'choices' => $this->categoryRepository->findBy([]),
                ]
            )
            ->add(
                'originalCode',
                TextType::class,
                [
                    'label' => 'Unikátní kód',
                    'required' => false,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název',
                ]
            )
            ->add(
                'vatRate',
                EnumType::class,
                [
                    'enum_class' => VatRate::class,
                    'label' => 'Daňová sazba',
                ]
            )
            ->add(
                'guarantee',
                EnumType::class,
                [
                    'enum_class' => Guarantee::class,
                    'label' => 'Záruka',
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'label' => 'Popis',
                    'required' => false,
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
                'cars',
                Select2EntityType::class,
                [
                    'label' => 'Kompatibilní vozy',
                    'class' => Car::class,
                    'multiple' => true,
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductCardModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'product_card_';
    }
}
