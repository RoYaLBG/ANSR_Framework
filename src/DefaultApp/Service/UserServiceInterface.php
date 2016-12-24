<?php

namespace DefaultApp\Service;


use DefaultApp\Model\Entity\User;

interface UserServiceInterface
{
    public function findAll();

    public function findOne($id): User;
}