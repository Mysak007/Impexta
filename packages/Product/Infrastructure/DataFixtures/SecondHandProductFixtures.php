<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Domain\Enum\VatRate;
use Impexta\Product\Domain\Factory\SecondHandProductImageFactory;
use Impexta\Product\Presentation\Form\Model\SecondHandProductImageModel;
use Money\Money;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class SecondHandProductFixtures extends Fixture
{
    private const NAMES = [
        'Okno Corvette C6',
        'Pontiac Firebird kapota',
        'Dodge Ram servisní manuál',
        'Hummer H2 zadní světlo',
        'Cadillac Escalade senzor sání motoru',
    ];

    private string $path = '';
    private SecondHandProductImageFactory $imageFactory;
    private SluggerInterface $slugger;

    public function __construct(
        SecondHandProductImageFactory $imageFactory,
        string $projectDir,
        SluggerInterface $slugger
    ) {
        $this->imageFactory = $imageFactory;
        $this->path = $projectDir . '/packages/Product/Infrastructure/DataFixtures/FixtureData/';
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $images = [
            [
                'window.jpg',
                'window1.jpeg',
                'window2.jpeg',
            ],
            [
                'hood.jpeg',
                'hood1.jpeg',
                'hood2.jpeg',
            ],
            [
                'manual.jpg',
                'manual1.jpg',
            ],
            [
                'light.jpeg',
                'light2.jpg',
                'light2.jpeg',
            ],
            [
                'sensor.jpg',
                'sensor1.jpg',
                'sensor2.jpg',
            ],
        ];

        $index = 0;

        foreach (self::NAMES as $name) {
            $slug = $this->slugger->slug($name)->toString();

            $secondHandProduct = new SecondHandProduct(
                $name,
                Money::CZK(random_int(199999, 499999)),
                VatRate::get(VatRate::BASE),
                $slug
            );

            $secondHandProduct->setPerex('Náhradní díl pro americké auto');
            $secondHandProduct->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Vestibulum finibus fringilla hendrerit. Proin quis massa pellentesque,
                cursus ex eget, mattis urna. Nullam eros dolor,
                placerat sit amet tincidunt a, vehicula in felis. Nulla id diam mi.
                Ut massa erat, consectetur eget nisi nec,
                finibus consectetur arcu. Nam quis lacinia eros, et mattis nulla.
                Pellentesque interdum lectus vitae aliquet convallis. Nunc vehicula.'
            );

            foreach ($images[$index] as $image) {
                $uploadedImage = new UploadedFile($this->path . $image, $image);
                $secondHandProductImageModel = new SecondHandProductImageModel();

                $secondHandProductImageModel->isMain = false;
                $secondHandProductImageModel->filename = null;
                $secondHandProductImageModel->file = $uploadedImage;

                $image = $this->imageFactory->create($secondHandProduct, $secondHandProductImageModel);
                $secondHandProduct->addSecondHandProductImage($image);
            }

            $manager->persist($secondHandProduct);
            ++$index;
        }

        $manager->flush();
    }
}
