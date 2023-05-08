<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveBankAccountController extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /** @Route("zakaznik/{id}/bankovni-ucet/smazat",
     *     name="client_crm_client_bank_account_delete",
     *     requirements={"id"="\d+"})
     */
    public function __invoke(Client $client): Response
    {
        $client->setBankAccount(null);
        $this->clientRepository->save($client);
        $this->addFlash('success', 'Bankovní účet byl odstraněn');

        return $this->redirectToRoute('client_crm_client_detail', [
            'id' => $client->getId(),
        ]);
    }
}
