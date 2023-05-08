<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteClientController extends AbstractController
{
    private ClientRepository $clientRepository;
    private ShopUserRepository $shopUserRepository;

    public function __construct(ClientRepository $clientRepository, ShopUserRepository $shopUserRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->shopUserRepository = $shopUserRepository;
    }

    /** @Route("zakaznik/{id}/smazat", name="client_crm_client_delete")
     */
    public function __invoke(Client $client): Response
    {
        $shopUsers = $this->shopUserRepository->findBy(['client' => $client]);

        foreach ($shopUsers as $shopUser) {
            $shopUser->setClient(null);
            $this->shopUserRepository->save($shopUser);
        }

        $this->clientRepository->removeAndSave($client);
        $this->addFlash('success', 'Klient byl odstraněn');

        return $this->redirectToRoute('client_crm_client_list');
    }
}
