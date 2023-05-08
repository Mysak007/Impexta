<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ChangeCurrencyController extends AbstractController
{
    /**
     * @Route("/mena/{currency}", name="order_eshop_currency_change")
     */
    public function __invoke(Request $request, SessionInterface $session, string $currency): Response
    {
        $session->set('currency', $currency);

        if ($request->headers->get('referer')) {
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirectToRoute('eshop_homepage');
    }
}
