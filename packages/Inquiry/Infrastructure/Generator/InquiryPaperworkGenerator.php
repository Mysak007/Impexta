<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Generator;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Twig\Environment;

final class InquiryPaperworkGenerator
{
    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function generate(Inquiry $inquiry): string
    {
        $itemRequests = $inquiry->getItemRequests();
        $itemOffers = [];

        /** @var InquiryItemRequestInterface $itemRequest */
        foreach ($itemRequests as $itemRequest) {
            foreach ($itemRequest->getItemOffers() as $itemOffer) {
                $itemOffers[] = $itemOffer;
            }
        }

        return $this->twig->render(
            '@inquiry/CRM/inquiry/pdf_template.html.twig',
            [
                'inquiry' => $inquiry,
                'itemRequests' => $itemRequests,
                'itemOffers' => $itemOffers,
            ]
        );
    }
}
