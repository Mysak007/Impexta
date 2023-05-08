<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Type;

use Impexta\Store\Presentation\Form\Model\StoreSpecialOpeningHoursModel;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StoreSpecialOpeningHoursType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'day',
                DatePickerType::class,
                [
                    'label' => 'Den',
                ]
            )
            ->add(
                'open',
                CheckboxType::class,
                [
                    'label' => 'Otevřeno',
                    'required' => false,
                ]
            )
            ->add(
                'opensAt',
                TimeType::class,
                [
                    'label' => 'Otevřeno od',
                    'required' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime_immutable',
                ]
            )
            ->add(
                'closesAt',
                TimeType::class,
                [
                    'label' => 'Otevřeno do',
                    'required' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime_immutable',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => StoreSpecialOpeningHoursModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'store_opening_hours_';
    }
}
