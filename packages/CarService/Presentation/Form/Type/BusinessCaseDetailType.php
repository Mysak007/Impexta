<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Type;

use Impexta\CarService\Presentation\Form\Model\BusinessCaseDetailModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BusinessCaseDetailType extends AbstractType
{
    /**
     * @param array<mixed, mixed> $options
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'data_class' => BusinessCaseDetailModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'business_case_detail_';
    }
}
