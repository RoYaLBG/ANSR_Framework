<?php
namespace ANSR\Core\Service\User;


use ANSR\Core\Service\Encryption\EncryptionServiceInterface;
use ANSR\Driver\DatabaseInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class UserService implements UserServiceInterface
{
    private $db;
    private $encryptionService;

    const ROLE_DEFAULT = 'USER';

    public function __construct(DatabaseInterface $db,
                                EncryptionServiceInterface $encryptionService)
    {
        $this->db = $db;
        $this->encryptionService = $encryptionService;
    }

    public function register($username, $password, array $roles = []): bool
    {
        $passwordHash = $this->encryptionService->encrypt($password);
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $statement = $this->db->prepare($query);
        $result = $statement->execute([$username, $passwordHash]);

        if (!$result) {
            return false;
        }

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


