<?php

namespace ANSR\Core\Data\Entity;

use ANSR\Core\Annotation\Type\Table;
use ANSR\Core\Annotation\Type\Id;

/**
 * @Table("users")
 * @Id("id")
 */
class User
{
    private $id;

    private $username;

    private $password;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

}