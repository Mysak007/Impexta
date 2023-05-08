<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type;

use Doctrine\ORM\EntityRepository;
use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Product\Presentation\Form\Model\FilterModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FilterType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'manufacturer',
                EntityType::class,
                [
                    'label' => 'Značka',
                    'class' => CarManufacturer::class,
                    'choice_label' => 'name',
                    'query_builder' => static function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('car')
                            ->where('car.showOnEshop = 1');
                    },
                    'placeholder' => '',
                    'attr' => [
                        'class' => 'Filter-carFilterSelect',
                    ],
                    'required' => false,
                ]
            )
            ->add(
                'model',
                ChoiceType::class,
                [
                    'label' => 'Model',
                    'placeholder' => '',
                    'attr' => [
                        'class' => 'Filter-carFilterSelect',
                    ],
                    'choices' => $options['choices_from_session']['model'],
                    'required' => false,
                ]
            )
            ->add(
                'yearOfManufacture',
                ChoiceType::class,
                [
                    'label' => 'Rok výroby',
                    'placeholder' => '',
                    'attr' => [
                        'class' => 'Filter-carFilterSelect',
                    ],
                    'choices' => $options['choices_from_session']['yearOfManufacture'],
                    'required' => false,
                ]
            )
            ->add(
                'engineCapacity',
                ChoiceType::class,
                [
                    'label' => 'Motorizace',
                    'placeholder' => '',
                    'attr' => [
                        'class' => 'Filter-carFilterSelect',
                    ],
                    'choices' => $options['choices_from_session']['engineCapacity'],
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterModel::class,
            'choices_from_session' => [],
            'attr' => [
                'class' => 'Filter-carFilter',
            ],
        ]);
    }
}
