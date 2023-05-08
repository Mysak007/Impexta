<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Type;

use Impexta\Inquiry\Presentation\Form\Model\InquiryClientEmailModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class InquiryClientEmailType extends AbstractType
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
                EmailType::class,
                [
                    'label' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => InquiryClientEmailModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'inquiry_client_email_';
    }
}
