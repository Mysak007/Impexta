<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Type;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShopUserAdminType extends AbstractType
{
    private ClientRepository $clientRepository;

    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }

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
                    'validation_groups' => 'registration',
                ]
            )
            ->add(
                'password',
                ShopUserPasswordType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'enabled',
                ChoiceType::class,
                [
                    'label' => 'Aktivní',
                    'choices' => [
                        'ano' => 1,
                        'ne' => 0,
                    ],
                ]
            )
            ->add(
                'client',
                Select2EntityType::class,
                [
                    'label' => 'Klient',
                    'class' => Client::class,
                    'choices' => $this->clientRepository->findClientsWithoutShopUser($options['shopUser']),
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ShopUserModel::class,
                'shopUser' => null,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'shop_user_';
    }
}
