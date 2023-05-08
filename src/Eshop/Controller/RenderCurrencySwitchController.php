<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class RenderCurrencySwitchController extends AbstractController
{
    public function __invoke(SessionInterface $session): Response
    {
        $currency = $session->get('currency');

        if (!$currency) {
            $currency = 'CZK';
            $session->set('currency', $currency);
        }

        return $this->render(
            'Eshop/components/_currency_switch.html.twig',
            [
                'currency' => $currency,
            ]
        );
    }
}
