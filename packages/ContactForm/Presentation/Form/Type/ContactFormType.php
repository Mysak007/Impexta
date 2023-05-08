<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Presentation\Form\Type;

use Impexta\ContactForm\Presentation\Form\Model\ContactFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactFormType extends AbstractType
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
                    'label' => 'Jméno a příjmení',
                    'attr' => ['class' => 'Form-input', 'tabindex' => 1],
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'Telefon',
                    'required' => false,
                    'attr' => ['class' => 'Form-input', 'tabindex' => 2],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'attr' => ['class' => 'Form-input', 'tabindex' => 3],
                ]
            )
            ->add(
                'vin',
                TextType::class,
                [
                    'label' => 'VIN',
                    'required' => false,
                    'attr' => ['class' => 'Form-input', 'tabindex' => 4],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Vzkaz',
                    'required' => true,
                    'attr' => ['class' => 'Form-input', 'tabindex' => 5, 'rows' => 5, 'cols' => 50],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ContactFormModel::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'contactForm_';
    }
}
