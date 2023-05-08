<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\Type;

use Impexta\Client\Domain\Entity\ClientCar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderCartType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'clientCars',
                ChoiceType::class,
                [
                    'label' => 'Vozidlo',
                    'required' => false,
                    'choices' => $options['cars'],
                    'choice_label' => static function (ClientCar $clientCar) {
                        return $clientCar->__toString();
                    },
                    'attr' => ['class' => 'Cart-carFilterSelect', 'style' => 'width:inherit'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => null,
                'cars' => null,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'order_client_cars_';
    }
}
