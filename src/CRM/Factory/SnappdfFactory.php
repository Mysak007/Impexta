<?php

declare(strict_types=1);

namespace App\CRM\Factory;

use Beganovich\Snappdf\Snappdf;

final class SnappdfFactory
{
    private string $chromiumBinaryPath;

    public function __construct(string $chromiumBinaryPath)
    {
        $this->chromiumBinaryPath = $chromiumBinaryPath;
    }

    public function __invoke(): Snappdf
    {
        $snappdf = new Snappdf();
        $snappdf->setChromiumPath($this->chromiumBinaryPath);

        return $snappdf;
    }
}
