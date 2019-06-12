<?php

namespace ANSR\Core\Service\Authentication;


use ANSR\Core\Data\Entity\User;
use ANSR\Core\Data\Repository\UserRepository;
use ANSR\Core\Http\Component\SessionInterface;
use ANSR\Core\Service\Encryption\EncryptionServiceInterface;
use ANSR\Driver\DatabaseInterface;
use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class AuthenticationService implements AuthenticationServiceInterface
{
    const KEY_SESSION_USER_ID = 'auth_id';

    private $session;
    private $db;
    private $encryptionService;
    private $userRepository;

    public function __construct(SessionInterface $session,
                                DatabaseInterface $db,
                                EncryptionServiceInterface $encryptionService,
                                UserRepository $userRepository)
    {
        $this->db = $db;
        $this->session = $session;
        $this->encryptionService = $encryptionService;
        $this->userRepository = $userRepository;
    }

    public function isLogged(): bool
    {
        return !empty($this->session->getAttribute(self::KEY_SESSION_USER_ID));
    }

    public function login($username, $password): bool
    {
        /** @var User $result */
        $result = $this->userRepository->findOneBy(['username' => $username]);

        if (!$result) {
            return false;
        }

        if ($this->encryptionService->verify($password, $result->getPassword())) {
            $this->session->setAttribute(self::KEY_SESSION_USER_ID, $result->getId());
            return true;
        }

        return false;
    }

    public function hasRole($roleName): bool
    {
        if (!$this->isLogged()) {
            return false;
        }

        $userId = $this->session->getAttribute(self::KEY_SESSION_USER_ID);

        $query = "SELECT COUNT(*) FROM user_roles INNER JOIN roles ON roles.id = user_roles.role_id WHERE roles.name = ? AND user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$roleName, $userId]);
        $row = $statement->fetchRow();

        return !empty($row) && $row['COUNT(*)'] > 0;
    }
}

