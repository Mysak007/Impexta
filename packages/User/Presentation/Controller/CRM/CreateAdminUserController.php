<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Domain\Factory\AdminUserFactory;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
use Impexta\User\Infrastructure\Security\AdminUserCrudVoter;
use Impexta\User\Presentation\Form\Model\AdminUserModel;
use Impexta\User\Presentation\Form\Type\AdminUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateAdminUserController extends AbstractController
{
    private AdminUserRepository $adminUserRepository;
    private AdminUserFactory $adminUserFactory;

    public function __construct(
        AdminUserRepository $adminUserRepository,
        AdminUserFactory $adminUserFactory
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminUserFactory = $adminUserFactory;
    }

    /**
     * @Route("administrator/vytvorit", name="user_crm_admin_user_create")
     */
    public function __invoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminUserCrudVoter::CREATE, AdminUserInterface::class);

        $model = AdminUserModel::createEmpty();
        $form = $this->createForm(AdminUserType::class, $model, [
            'validation_groups' => [
                'Default',
                'registration',
            ],
            'password_required' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->adminUserFactory->create($model);

            $this->adminUserRepository->save($user);
            $this->addFlash('success', 'Uživatel byl vytvořen');

            $userId = $user->getId();

            return $this->redirectToRoute('user_crm_admin_user_detail', ['id' => $userId]);
        }

        return $this->render(
            '@user/CRM/user_admin_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
