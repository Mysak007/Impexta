<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Impexta\Product\Presentation\Form\Model\ProductImageModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class ProductImageType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'isMain',
                CheckboxType::class,
                [
                    'label' => 'Nastavit jako hlavní fotku',
                    'required' => false,
                ]
            )
            ->add(
                'file',
                VichFileType::class,
                [
                    'label' => false,
                    'required' => false,
                    'help' => 'Rozměry obrázku by měly být 450x300.',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ProductImageModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'product_image_';
    }
}
