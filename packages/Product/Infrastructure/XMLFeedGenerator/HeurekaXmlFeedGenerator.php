<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator;

final class HeurekaXmlFeedGenerator extends AbstractXmlFeedGenerator
{
    public const NAME = 'heureka';

    public function getTemplate(): string
    {
        return '@product/XMLFeedGenerator/heureka.xml.twig';
    }

    public static function name(): string
    {
        return self::NAME;
    }
}
