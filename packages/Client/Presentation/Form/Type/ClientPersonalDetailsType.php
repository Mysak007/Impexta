<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use Impexta\Client\Presentation\Form\Model\ClientPersonalDetailsModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientPersonalDetailsType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Jméno',
                    'required' => false,
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Příjmení',
                    'required' => false,
                ]
            )
            ->add(
                'companyName',
                TextType::class,
                [
                    'label' => 'Název firmy',
                    'required' => false,
                ]
            )
            ->add(
                'taxId',
                TextType::class,
                [
                    'label' => 'IČ',
                    'required' => false,
                ]
            )
            ->add(
                'vatId',
                TextType::class,
                [
                    'label' => 'DIČ',
                    'required' => false,
                ]
            )
            ->add(
                'vatIdSk',
                TextType::class,
                [
                    'label' => 'IČ DPH',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientPersonalDetailsModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_personal_details_';
    }
}
