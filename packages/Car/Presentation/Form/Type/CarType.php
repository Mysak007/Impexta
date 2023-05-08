<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Car\Domain\Enum\CarCategory;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Impexta\Car\Presentation\Form\Model\CarModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CarType extends AbstractType
{
    private CarManufacturerRepository $carManufacturerRepository;

    public function __construct(CarManufacturerRepository $carManufacturerRepository)
    {
        $this->carManufacturerRepository = $carManufacturerRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'manufacturer',
                Select2ChoiceType::class,
                [
                    'label' => 'Výrobce',
                    'choices' => $this->carManufacturerRepository->getIdAndNameAsAssociativeArray(),
                    'choice_label' => static function (string $carManufacturer) {
                        return $carManufacturer;
                    },
                    'choice_attr' => static function ($choice, $key) {
                        return ['data-id' => $key];
                    },
                    'placeholder' => 'Vyberte výrobce',
                    'required' => true,
                    'allow_extra_fields' => true,
                ]
            )
            ->add(
                'category',
                EnumType::class,
                [
                    'enum_class' => CarCategory::class,
                    'label' => 'Kategorie',
                ]
            )
            ->add(
                'model',
                TextType::class,
                [
                    'label' => 'Model',
                    'attr' => ['class' => 'select2'],
                ]
            )
            ->add(
                'yearOfManufacture',
                TextareaType::class,
                [
                    'label' => 'Rok výroby',
                    'help' => 'Rok výroby musí být po roce 1900. Více hodn' .
                        'ot oddělte Enterem.',
                ]
            )
            ->add(
                'engineCapacity',
                TextareaType::class,
                [
                    'label' => 'Objem motoru',
                    'help' => 'Objem motoru musí být desetinné číslo. Více' .
                        ' hodnot oddělte Enterem.',
                ]
            )
            ->add(
                'note',
                TextareaType::class,
                [
                    'label' => 'Poznámka',
                    'required' => false,
                ]
            )
            ->add(
                'hideOnEshop',
                CheckboxType::class,
                [
                    'label' => 'Schovat na eshopu',
                    'required' => false,
                ]
            );

        $builder->get('manufacturer')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => CarModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'car_';
    }
}
