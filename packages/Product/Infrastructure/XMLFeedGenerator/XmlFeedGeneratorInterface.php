<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator;

use App\Eshop\Enum\Country;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedModel;

interface XmlFeedGeneratorInterface
{
    public function getTemplate(): string;

    public function generate(XmlFeedModel $feedModel, Country $country): string;

    public static function name(): string;
}
