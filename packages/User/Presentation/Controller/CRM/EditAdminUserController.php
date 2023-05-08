<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
use Impexta\User\Infrastructure\Security\AdminUserCrudVoter;
use Impexta\User\Presentation\Form\Model\AdminUserModel;
use Impexta\User\Presentation\Form\Type\AdminUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class EditAdminUserController extends AbstractController
{
    private AdminUserRepository $userRepository;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        AdminUserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("administrator/{id}/upravit", name="user_crm_admin_user_edit")
     */
    public function __invoke(AdminUser $adminUser, Request $request): Response
    {
        $this->denyAccessUnlessGranted(AdminUserCrudVoter::EDIT, $adminUser);

        $model = AdminUserModel::createFromEntity($adminUser);

        $form = $this->createForm(AdminUserType::class, $model);
        $form
            ->remove('username');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($model->password) {
                $model->password = $this->passwordEncoder->encodePassword($adminUser, $model->password);
            }

            $adminUser->mapFromAdminUserModel($model);

            $this->userRepository->save($adminUser);
            $this->addFlash('success', 'Uživatel byl aktualizovaný');

            $userId = $adminUser->getId();

            return $this->redirectToRoute('user_crm_admin_user_detail', ['id' => $userId]);
        }

        return $this->render(
            '@user/CRM/user_admin_edit.html.twig',
            [
                'admin' => $adminUser,
                'form' => $form->createView(),
            ]
        );
    }
}
