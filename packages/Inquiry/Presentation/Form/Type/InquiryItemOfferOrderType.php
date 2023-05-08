<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Impexta\Inquiry\Domain\Entity\InquiryItemOffer;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemOfferRepository;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemOfferOrderModel;
use Microshop\SymfonySurvivalKit\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryItemOfferOrderType extends AbstractType
{
    private InquiryItemOfferRepository $inquiryItemOfferRepository;

    public function __construct(InquiryItemOfferRepository $inquiryItemOfferRepository)
    {
        $this->inquiryItemOfferRepository = $inquiryItemOfferRepository;
    }

    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'isSelected',
                CheckboxType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'inquiryItemOffer',
                Select2EntityType::class,
                [
                    'label' => 'Nabízený díl',
                    'class' => InquiryItemOffer::class,
                    'required' => false,
                    'choice_label' => static function (InquiryItemOffer $inquiryItemOffer) {
                        return $inquiryItemOffer->getProduct()->getName();
                    },
                    'choices' => $this->inquiryItemOfferRepository->findBy([]),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryItemOfferOrderModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_item_order_';
    }
}
