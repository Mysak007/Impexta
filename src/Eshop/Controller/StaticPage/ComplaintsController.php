<?php

declare(strict_types=1);

namespace App\Eshop\Controller\StaticPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ComplaintsController extends AbstractController
{
    /**
     * @Route("/reklamace", name="eshop_static_page_complaints")
     */
    public function __invoke(): Response
    {
        return $this->render(
            'Eshop/static_page/complaints.html.twig',
        );
    }
}
