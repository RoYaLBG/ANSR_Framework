<?php

namespace DefaultApp\Controller;

use ANSR\Core\Annotation\Type\Route;
use ANSR\Core\Annotation\Type\Auth;
use ANSR\Core\Controller\Controller;
use ANSR\Core\Http\Component\SessionInterface;
use ANSR\Core\Http\Response\ViewResponse;
use ANSR\Core\Http\Response\RedirectResponse;
use ANSR\Core\Service\Authentication\AuthenticationServiceInterface;
use ANSR\Core\Service\User\UserServiceInterface;
use DefaultApp\Model\Form\UserLoginBindingModel;
use DefaultApp\Model\Form\UserRegisterBindingModel;
use DefaultApp\Model\View\UserProfileViewModel;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class UsersController extends Controller
{
    /**
     * @Route("/login", name="login", method="GET")
     *
     * @return ViewResponse
     */
    public function login()
    {
        return $this->view();
    }

    /**
     * @Route("/login", name="login_process", method="POST")
     *
     * @param AuthenticationServiceInterface $authenticationService
     * @param UserLoginBindingModel $bindingModel
     * @return RedirectResponse
     */
    public function loginProcess(AuthenticationServiceInterface $authenticationService,
                                 UserLoginBindingModel $bindingModel)
    {
        if ($authenticationService->login($bindingModel->getUsername(), $bindingModel->getPassword())) {
            return $this->redirectToRoute("user_profile");
        }

        $this->addFlash(SessionInterface::KEY_FLASH_ERROR, "Login failed");

        return $this->redirectToRoute("login");
    }

    /**
     * @Route("/users/register", name="register_user", method="GET")
     *
     * @return ViewResponse
     */
    public function register()
    {
        return $this->view();
    }

    /**
     * @Route("/users/register", name="register_user_process", method="POST")
     *
     * @param UserServiceInterface $userService
     * @param UserRegisterBindingModel $bindingModel
     * @return RedirectResponse
     */
    public function registerProcess(UserServiceInterface $userService,
                                    UserRegisterBindingModel $bindingModel)
    {
        if ($bindingModel->getPassword() != $bindingModel->getConfirmPassword()) {
            $this->addFlash(SessionInterface::KEY_FLASH_ERROR, "Passwords mismatch");

            return $this->redirectToRoute("register_user");
        }

        if ($userService->register($bindingModel->getUsername(), $bindingModel->getPassword())) {
            $this->addFlash(SessionInterface::KEY_FLASH_SUCCESS, "Register successful");

            return $this->redirectToRoute("login");
        }

        $this->addFlash(SessionInterface::KEY_FLASH_ERROR, "Username already taken");

        return $this->redirectToRoute("register_user");
    }

    /**
     * @Route("/users/me/courses/{id}/enroll", name="enroll_to_course", method="GET")
     * @Auth("ADMIN")
     *
     * @param int $courseId
     */
    public function enrollToCourse(int $courseId)
    {

    }

    /**
     * @Route("/users/profile", name="user_profile", method="GET")
     * @Auth("USER")
     *
     * @param \DefaultApp\Service\UserServiceInterface $userService
     * @return ViewResponse
     */
    public function profile(\DefaultApp\Service\UserServiceInterface $userService)
    {
        $id = $this->getId();
        $user = $userService->findOne($id);

        $viewModel = new UserProfileViewModel();
        $viewModel->setUsername($user->getUsername());

        return $this->view($viewModel);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function logout(SessionInterface $session)
    {
        $session->destroy();

        return $this->redirectToRoute("login");
    }
}