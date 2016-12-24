<?php
namespace ANSR\Core\Service\User;

interface UserServiceInterface
{
    public function register($username, $password, array $roles = []): bool;
}

