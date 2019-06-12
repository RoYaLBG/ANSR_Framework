<?php

namespace ANSR\Core\Service\User;


use ANSR\Core\Data\Entity\User;
use ANSR\Core\Data\EntityManagerInterface;
use ANSR\Core\Data\Repository\UserRepository;
use ANSR\Core\Service\Encryption\EncryptionServiceInterface;
use ANSR\Driver\DatabaseInterface;
use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class UserService implements UserServiceInterface
{
    const ROLE_DEFAULT = 'USER';

    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(DatabaseInterface $db,
                                EncryptionServiceInterface $encryptionService,
                                UserRepository $userRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->db = $db;
        $this->encryptionService = $encryptionService;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }


    public function register($username, $password, array $roles = []): bool
    {
        $passwordHash = $this->encryptionService->encrypt($password);
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($passwordHash);

        $this->entityManager->persist($user);

        if (empty($roles)) {
            $roles = [self::ROLE_DEFAULT];
        }

        $userId = $this->db->lastId();

        foreach ($roles as $role) {
            $statement = $this->db->prepare("SELECT id FROM roles WHERE name = ?");
            $statement->execute([$role]);
            $row = $statement->fetchRow();
            $query = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";

            $insertStatement = $this->db->prepare($query);
            $insertStatement->execute([$userId, $row['id']]);
        }

        return true;
    }
}


