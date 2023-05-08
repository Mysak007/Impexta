<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListClientController extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @Route("zakaznici", name="client_crm_client_list")
     */
    public function __invoke(): Response
    {
        $clients = $this->clientRepository->findAll();

        return $this->render('@client/CRM/client_list.html.twig', [
            'clients' => $clients,
        ]);
    }
}
