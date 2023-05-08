<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Inquiry\Domain\Enum\InquiryOrigin;
use Impexta\Inquiry\Presentation\Form\Model\InquiryModel;
use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
use Microshop\SymfonySurvivalKit\Form\Type\DatePickerType;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryType extends AbstractType
{
    private AdminUserRepository $userRepository;

    public function __construct(
        AdminUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'assignee',
                Select2EntityType::class,
                [
                    'label' => 'Přiřazeno',
                    'placeholder' => 'Vyberte přiřazeného pracovníka',
                    'class' => AdminUser::class,
                    'required' => false,
                    'choices' => $this->userRepository->findBy([], [
                        'username' => 'ASC',
                    ]),
                ]
            )
            ->add(
                'origin',
                EnumType::class,
                [
                    'label' => 'Původ',
                    'enum_class' => InquiryOrigin::class,
                ]
            )
            ->add(
                'receivedAt',
                DatePickerType::class,
                [
                    'label' => 'Obdrženo',
                    'invalid_message' => 'Zadejte prosím datum ve formátu: dd.MM.yyyy',
                    'required' => true,
                ]
            )
            ->add(
                'expiration',
                DatePickerType::class,
                [
                    'label' => 'Expirace',
                    'invalid_message' => 'Zadejte prosím datum ve formátu: dd.MM.yyyy',
                    'required' => true,
                ]
            )
            ->add(
                'client',
                EntityType::class,
                [
                    'label' => 'Klient',
                    'placeholder' => 'Vyberte klienta',
                    'class' => Client::class,
                    'required' => true,
                ]
            )
            ->add(
                'sale',
                NumberType::class,
                [
                    'required' => true,
                    'label' => 'Sleva',
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
                'itemRequests',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => false,
                    'entry_type' => InquiryItemRequestType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Uložit',
                    'attr' => ['class' => 'btn btn-success pull-right'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_';
    }
}
