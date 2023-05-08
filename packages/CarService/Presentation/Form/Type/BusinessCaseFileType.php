<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Type;

use Impexta\CarService\Presentation\Form\Model\BusinessCaseFileModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class BusinessCaseFileType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param array<mixed, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'file',
                VichFileType::class,
                [
                    'label' => false,
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BusinessCaseFileModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'business_case_file_';
    }
}
