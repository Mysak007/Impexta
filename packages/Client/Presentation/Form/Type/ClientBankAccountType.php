<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Type;

use Impexta\Client\Presentation\Form\Model\ClientBankAccountModel;
use Microshop\SymfonySurvivalKit\Enum\Bank;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ClientBankAccountType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'bankName',
                Select2EnumType::class,
                [
                    'enum_class' => Bank::class,
                    'label' => 'Název banky',
                    'required' => false,
                    'choice_label' => static function (Bank $bank) {
                        return $bank->getReadable() . ' - ' . $bank->getValue();
                    },
                ]
            )
            ->add(
                'number',
                TextType::class,
                [
                    'label' => 'Číslo účtu',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ClientBankAccountModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'client_bank_account_';
    }
}
