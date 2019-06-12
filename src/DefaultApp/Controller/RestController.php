<?php
namespace DefaultApp\Controller;

use ANSR\Core\Annotation\Type\Route;
use ANSR\Core\Controller\Controller;
use ANSR\Core\Http\Response\JsonResponse;
use DefaultApp\Model\View\UserProfileViewModel;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class RestController extends Controller
{

    /**
     * @Route("/users", name="all_users", method="GET")
     *
     * @return JsonResponse
     */
    public function getAllUsers()
    {
        $userOne = new UserProfileViewModel();
        $userOne->setUsername("John");
        $userOne->setPassword(uniqid());

        $userTwo = new UserProfileViewModel();
        $userTwo->setUsername("Maria");
        $users = [$userOne, $userTwo];

        return $this->json($users);
    }

    /**
     * @Route("/user/{id}", name="one_user", method="GET")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getOne(int $id)
    {
        $user = new UserProfileViewModel();
        $user->setUsername($id . ": " . uniqid());
        $user->setPassword(uniqid());

        return $this->json($user);
    }
}

