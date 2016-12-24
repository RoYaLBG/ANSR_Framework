<?php
namespace ANSR\Core\Service\Authentication;

interface AuthenticationServiceInterface
{
    public function isLogged(): bool;

    public function login($username, $password): bool;

    public function hasRole($roleName): bool;
}

