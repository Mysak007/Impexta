<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator;

final class ZboziXmlFeedGenerator extends AbstractXmlFeedGenerator
{
    public const NAME = 'zbozi';

    public function getTemplate(): string
    {
        return '@product/XMLFeedGenerator/zbozi.xml.twig';
    }

    public static function name(): string
    {
        return self::NAME;
    }
}
