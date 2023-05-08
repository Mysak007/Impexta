<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\CarService\Domain\Enum\BusinessCaseState;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseModel;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Microshop\SymfonySurvivalKit\Money\Form\MoneyWithCurrencyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BusinessCaseType extends AbstractType
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'client',
                EntityType::class,
                [
                    'label' => 'Klient',
                    'placeholder' => 'Vyberte klienta',
                    'class' => Client::class,
                    'required' => true,
                    'disabled' => $options['disabled_client'],
                    'choices' => $this->clientRepository->findAll(),
                    'choice_label' => static function ($client) {
                        return $client->getPersonalDetails()->getName();
                    },
                ]
            )
            ->add(
                'state',
                EnumType::class,
                [
                    'enum_class' => BusinessCaseState::class,
                    'label' => 'Stav',
                ]
            )
            ->add(
                'insuredEvent',
                CheckboxType::class,
                [
                    'label' => 'Pojistná událost?',
                    'required' => false,
                ]
            )
            ->add(
                'priceEstimate',
                MoneyWithCurrencyType::class,
                [
                    'label' => 'Předpokládaná cena',
                    'currencies' => ['CZK' => 'Kč','EUR' => '€'],
                ]
            )
            ->add(
                'finalPrice',
                MoneyWithCurrencyType::class,
                [
                    'label' => 'Výsledná cena',
                    'currencies' => ['CZK' => 'Kč','EUR' => '€'],

                ]
            )
            ->add(
                'takenInAt',
                DatePickerType::class,
                [
                    'label' => 'Převzato dne',
                ]
            )
            ->add(
                'realizationAt',
                DatePickerType::class,
                [
                    'label' => 'Datum realizace',
                ]
            )
            ->add(
                'handOverAt',
                DatePickerType::class,
                [
                    'label' => 'Datum předání',
                ]
            )
            ->add(
                'vehicle',
                BusinessCaseVehicleType::class,
                [
                    'label' => false,
                    'required' => false,
                ]
            )
            ->add(
                'files',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => BusinessCaseFileType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )->add(
                'images',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => BusinessCaseImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BusinessCaseModel::class,
                'disabled_client' => false,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'business_case_';
    }
}
