<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Factory\ClientFactory;
use Impexta\Client\Infrastructure\Repository\ClientRepository;
use Impexta\Client\Infrastructure\Service\UploadedFileService;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Impexta\Client\Presentation\Form\Type\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateClientController extends AbstractController
{
    private ClientRepository $clientRepository;
    private ClientFactory $clientFactory;
    private UploadedFileService $uploadedFileService;

    public function __construct(
        ClientRepository $clientRepository,
        ClientFactory $clientFactory,
        UploadedFileService $uploadedFileService
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientFactory = $clientFactory;
        $this->uploadedFileService = $uploadedFileService;
    }

    /**
     * @Route("zakaznik/vytvorit", name="client_crm_client_create")
     */
    public function __invoke(Request $request): Response
    {
        $clientModel = ClientModel::createEmpty();
        $form = $this->createForm(ClientType::class, $clientModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $this->clientFactory->createClient($clientModel);

            if ($clientModel->logo) {
                $this->uploadedFileService->uploadLogo($form, $client);
            }

            $this->clientRepository->save($client);

            $this->addFlash('success', 'Zákazník byl vytvořen.');

            return $this->redirectToRoute('client_crm_client_detail', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('@client/CRM/client_create.html.twig', [
            'form' => $form->createView(),
            'smartform_instances' => [ClientType::BILLING_ADDRESS, ClientType::SHIPPING_ADDRESS],
        ]);
    }
}
