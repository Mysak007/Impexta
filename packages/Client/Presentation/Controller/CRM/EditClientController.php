<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Infrastructure\Mapper\ClientMapper;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Impexta\Client\Infrastructure\Service\UploadedFileService;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Impexta\Client\Presentation\Form\Type\ClientType;
use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditClientController extends AbstractController
{
    private ClientRepository $clientRepository;
    private ClientMapper $clientMapper;
    private UploadedFileService $uploadedFileService;
    private OrderRepository $orderRepository;

    public function __construct(
        ClientRepository $clientRepository,
        ClientMapper $clientMapper,
        UploadedFileService $uploadedFileService,
        OrderRepository $orderRepository
        //TODO přidat inquiry
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientMapper = $clientMapper;
        $this->uploadedFileService = $uploadedFileService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("zakaznik/{id}/upravit", name="client_crm_client_edit")
     */
    public function __invoke(Client $client, Request $request): Response
    {
        $model = ClientModel::createFromEntity($client);
        $form = $this->createForm(ClientType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->clientMapper->mapFromModel($model, $client);

            if ($model->logo) {
                $this->uploadedFileService->updateLogo($form, $model, $client);
            }

            $this->clientRepository->save($client);
            $this->addFlash('success', 'Zákazník byl aktualizován');

            $clientId = $client->getId();

            return $this->redirectToRoute('client_crm_client_detail', ['id' => $clientId]);
        }

        $allowRemove = true;
        $order = $this->orderRepository->findOneBy(['client' => $client]);

        if ($order) {
            $allowRemove = false;
        }

        return $this->render('@client/CRM/client_edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'smartform_instances' => [ClientType::BILLING_ADDRESS, ClientType::SHIPPING_ADDRESS],
            'allow_remove' => $allowRemove,
        ]);
    }
}
