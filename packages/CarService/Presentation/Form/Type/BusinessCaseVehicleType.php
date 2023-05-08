<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Type;

use Impexta\CarService\Presentation\Form\Model\BusinessCaseVehicleModel;
use Impexta\Client\Domain\Entity\ClientCar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BusinessCaseVehicleType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'clientCar',
                EntityType::class,
                [
                    'label' => 'Vozidlo klienta',
                    'class' => ClientCar::class,
                    'choice_label' => static function ($clientCar) {
                        return $clientCar->getCar()->__toString();
                    },
                ]
            )
            ->add(
                'fuelState',
                NumberType::class,
                [
                    'label' => 'Stav paliva',
                    'required' => false,
                ]
            )
            ->add(
                'note',
                TextareaType::class,
                [
                    'label' => 'Poznámka',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BusinessCaseVehicleModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'business_case_vehicle_';
    }
}
