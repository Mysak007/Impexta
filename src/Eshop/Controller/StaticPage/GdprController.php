<?php

declare(strict_types=1);

namespace App\Eshop\Controller\StaticPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GdprController extends AbstractController
{
    /**
     * @Route("/gdpr", name="eshop_static_page_gdpr")
     */
    public function __invoke(): Response
    {
        return $this->render(
            'Eshop/static_page/gdpr.html.twig',
        );
    }
}
