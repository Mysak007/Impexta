<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Client\Domain\Entity\ClientCar;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemRequestModel;
use Impexta\Product\Domain\Entity\ProductCard;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryItemRequestType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'productCard',
                Select2EntityType::class,
                [
                    'label' => 'Produkt',
                    'class' => ProductCard::class,
                    'required' => true,
                ]
            )
            ->add(
                'clientCar',
                EntityType::class,
                [
                    'label' => 'Vozidlo klienta',
                    'class' => ClientCar::class,
                    'required' => false,
                ]
            )
            ->add(
                'car',
                EntityType::class,
                [
                    'label' => 'Vozidlo',
                    'class' => Car::class,
                    'required' => false,
                ]
            )
            ->add(
                'quantity',
                NumberType::class,
                [
                    'required' => true,
                    'label' => 'Množství',
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
                'itemOffers',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => false,
                    'entry_type' => InquiryItemOfferType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'disabled' => $options['itemOffersDisabled'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryItemRequestModel::class,
                'itemOffersDisabled' => true,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_item_request_';
    }
}
