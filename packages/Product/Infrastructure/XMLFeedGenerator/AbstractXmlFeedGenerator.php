<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator;

use App\Eshop\Enum\Country;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedModel;
use Money\Currency;
use Twig\Environment;

abstract class AbstractXmlFeedGenerator implements XmlFeedGeneratorInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function generate(XmlFeedModel $feedModel, Country $country): string
    {
        return $this->environment->render($this->getTemplate(), [
            'products' => $feedModel->products,
            'currency' => new Currency(Country::getCurrency($country)),
        ]);
    }
}
