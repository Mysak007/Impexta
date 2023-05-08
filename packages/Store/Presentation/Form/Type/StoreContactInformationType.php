<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Type;

use Impexta\Store\Presentation\Form\Model\StoreContactInformationModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StoreContactInformationType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'E-mail',
                    'required' => false,
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'Telefon',
                    'required' => false,
                ]
            )
            ->add(
                'landline',
                TextType::class,
                [
                    'label' => 'Pevná linka',
                    'required' => false,
                ]
            )
            ->add(
                'skype',
                TextType::class,
                [
                    'label' => 'Skype',
                    'required' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => StoreContactInformationModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'store_contact_information_';
    }
}
