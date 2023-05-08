<?php

declare(strict_types=1);

namespace App\Eshop\Controller\StaticPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeliveryAndPaymentController extends AbstractController
{
    /** @Route("/doprava-a-platba", name="eshop_static_page_delivery_and_payment") */
    public function __invoke(): Response
    {
        return $this->render('Eshop/static_page/delivery_and_payment.html.twig');
    }
}
