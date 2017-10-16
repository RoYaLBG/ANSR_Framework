<?php

namespace DefaultApp\Model\View;


class UserProfileViewModel
{
    private $username;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
}