<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Impexta\Product\Presentation\Form\Model\SecondHandProductImageModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class SecondHandProductImageType extends AbstractType
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
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => SecondHandProductImageModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'secondhand_product_image_';
    }
}
