<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\CarService\Domain\Enum\BusinessCaseCommunicationChannel;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseCommunicationModel;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BusinessCaseCommunicationType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'communicatedAt',
                DatePickerType::class,
                [
                    'label' => 'Zpráva přijata',
                ]
            )
            ->add(
                'channel',
                EnumType::class,
                [
                    'enum_class' => BusinessCaseCommunicationChannel::class,
                    'label' => 'Komunikační kanál',
                ]
            )
            ->add(
                'communication',
                TextareaType::class,
                [
                    'label' => 'Zpráva',
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BusinessCaseCommunicationModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'business_case_communication_';
    }
}
