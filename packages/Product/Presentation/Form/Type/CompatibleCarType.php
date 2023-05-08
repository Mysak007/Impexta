<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Product\Presentation\Form\Model\CompatibleCarModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CompatibleCarType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'car',
                Select2EntityType::class,
                [
                    'label' => false,
                    'class' => Car::class,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompatibleCarModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'compatible_car_';
    }
}
