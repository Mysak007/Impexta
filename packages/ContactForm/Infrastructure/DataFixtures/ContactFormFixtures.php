<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\ContactForm\Domain\Entity\ContactForm;

final class ContactFormFixtures extends Fixture
{
    private const NAMES = [
        'Pavel',
        'Marek',
        'Luboš',
        'Ivo',
        'Albert',
        'Quido',
        'Patrik',
        'Lukáš',
        'Michal',
        'Jakub',
        'Jan',
    ];

    public function load(ObjectManager $manager): void
    {

        $message = 'Lorem ipsum dolor sit amet,
        consectetur adipiscing elit. Cras posuere ornare est,
        ut vestibulum purus rutrum non. Pellentesque pellentesque,
        lacus id eleifend placerat, lacus tellus vestibulum justo,
        quis rhoncus sapien eros id nisi. Aliquam bibendum imperdiet nunc vel
        laoreet. Quisque dapibus sagittis malesuada. Lorem ipsum dolor sit amet,
        consectetur adipiscing elit. Aenean viverra in erat ac placerat. Nunc enim
        felis, varius quis vulputate vitae, volutpat sit amet erat. Vivamus
        lobortis ex sit amet ligula molestie, vitae consectetur elit gravida.
        Pellentesque vel hendrerit tellus.';

        foreach (self::NAMES as $name) {
            $contactForm = new ContactForm(
                $name,
                'email@example.com',
                $message,
            );
            $contactForm->setVin('123456789');

            $manager->persist($contactForm);
        }

        $manager->flush();
    }
}
