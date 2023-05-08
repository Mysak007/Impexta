<?php

declare(strict_types=1);

namespace App\Eshop\Controller\StaticPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TermsAndConditionsController extends AbstractController
{
    /**
     * @Route("/obchodni-podminky", name="eshop_static_page_terms_and_conditions")
     */
    public function __invoke(): Response
    {
        return $this->render(
            'Eshop/static_page/terms_and_conditions.html.twig',
        );
    }
}
