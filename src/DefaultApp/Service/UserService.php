<?php

namespace DefaultApp\Service;


use ANSR\Driver\DatabaseInterface;
use DefaultApp\Model\Entity\Role;
use DefaultApp\Model\Entity\User;

class UserService implements UserServiceInterface
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "SELECT id, username, password FROM users";
        $statement = $this->db->prepare($query);
        $statement->execute();

        /** @var User $user */
        while ($user = $statement->fetchObject(User::class)) {
            $this->populateUserRoles($user);

            yield $user;
        }
    }

    public function findOne($id): User
    {
        $query = "SELECT id, username, password FROM users WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        /** @var User $user */
        $user = $statement->fetchObject(User::class);

        $this->populateUserRoles($user);

        return $user;
    }

    private function populateUserRoles(User $user)
    {
        $query = "SELECT roles.id, roles.name FROM roles INNER JOIN user_roles WHERE user_roles.user_id = ?";
        $roleStatement = $this->db->prepare($query);
        $roleStatement->execute([$user->getId()]);
        while ($role = $roleStatement->fetchObject(Role::class)) {
            $user->addRole($role);
        }
    }
}