<?php

namespace DefaultApp\Model\View;

use ANSR\Core\Annotation\Type\ResponseExclude;

class UserProfileViewModel
{
    private $username;

    private $password;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @ResponseExclude
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


}