<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Type;

use Impexta\Store\Presentation\Form\Model\StoreOpeningHoursModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StoreOpeningHoursType extends AbstractType
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
                Select2ChoiceType::class,
                [
                    'label' => 'Den',
                    'choices' => [
                        'Pondělí' => 1,
                        'Úterý' => 2,
                        'Středa' => 3,
                        'Čtvrtek' => 4,
                        'Pátek' => 5,
                        'Sobota' => 6,
                        'Neděle' => 7,
                    ],
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
                'data_class' => StoreOpeningHoursModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'store_opening_hours_';
    }
}
