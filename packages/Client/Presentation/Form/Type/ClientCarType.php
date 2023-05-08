<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Impexta\Client\Presentation\Form\Model\ClientCarModel;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientCarType extends AbstractType
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

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
                    'label' => 'Vozidlo',
                    'class' => Car::class,
                    'choices' => $this->carRepository->findAll(),
                ]
            )
            ->add(
                'licensePlate',
                TextType::class,
                [
                    'label' => 'SPZ',
                    'required' => false,
                ]
            )
            ->add(
                'vin',
                TextType::class,
                [
                    'label' => 'VIN',
                    'required' => false,
                ]
            )
            ->add(
                'technicalInspectionExpiresAt',
                DatePickerType::class,
                [
                    'label' => 'Datum konce STK',
                    'invalid_message' => 'Zadejte prosím datum ve formátu: dd.MM.yyyy',
                    'required' => false,
                ]
            )
            ->add(
                'ownerName',
                TextType::class,
                [
                    'label' => 'Název',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientCarModel::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'client_car_';
    }
}
