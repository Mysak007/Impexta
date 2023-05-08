<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Type\Eshop;

use Impexta\Product\Presentation\Form\Model\Eshop\SecondHandProductContactFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SecondHandProductContactFormType extends AbstractType
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
                    'label' => 'Email',
                    'required' => true,
                ]
            )
            ->add(
                'text',
                TextareaType::class,
                [
                    'label' => 'Text zprávy',
                    'required' => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Odeslat',
                    'attr' => ['class' => 'btn btn-primary'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SecondHandProductContactFormModel::class,
        ]);
    }
}
