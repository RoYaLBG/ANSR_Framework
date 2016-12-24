<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 12/24/2016
 * Time: 12:58 AM
 */

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