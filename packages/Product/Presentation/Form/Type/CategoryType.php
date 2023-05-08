<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Presentation\Form\Model\CategoryModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CategoryType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'parent',
                Select2EntityType::class,
                [
                    'label' => 'Nadřazená kategorie',
                    'class' => Category::class,
                    'choice_label' => static function (Category $category) {
                        return $category->getName();
                    },
                    'required' => false,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'category_';
    }
}
