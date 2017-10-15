<?php
namespace ANSR\Core\Service\Authentication;



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

    public function __construct(SessionInterface $session,
                                DatabaseInterface $db,
                                EncryptionServiceInterface $encryptionService)
    {
        $this->db = $db;
        $this->session = $session;
        $this->encryptionService = $encryptionService;
    }

    public function isLogged(): bool
    {
        return !empty($this->session->getAttribute(self::KEY_SESSION_USER_ID));
    }

    public function login($username, $password): bool
    {
        $query = "SELECT id, password FROM users WHERE username = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$username]);
        $result = $statement->fetchRow();

        if (!$result) {
            return false;
        }

        if ($this->encryptionService->verify($password, $result['password'])) {
            $this->session->setAttribute(self::KEY_SESSION_USER_ID, $result['id']);
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

        return !empty($row);
    }
}

