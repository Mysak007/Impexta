<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Type;

use App\Eshop\Enum\Country;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Store\Presentation\Form\Model\StoreModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StoreType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Název',
                ]
            )
            ->add(
                'country',
                EnumType::class,
                [
                    'label' => 'Země',
                    'enum_class' => Country::class,
                    'choice_attr' => static function (Country $country) {
                        return ['data-code' => Country::getCode($country)];
                    },
                    'mapped' => false,
                ]
            )
            ->add(
                'address',
                StoreAddressType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'contactInformation',
                StoreContactInformationType::class,
                [
                    'label' => 'Kontaktní informace',
                ]
            )
            ->add(
                'openingHours',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => false,
                    'entry_type' => StoreOpeningHoursType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => StoreModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'store_';
    }
}
