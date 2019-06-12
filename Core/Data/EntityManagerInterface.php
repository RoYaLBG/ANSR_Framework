<?php

namespace ANSR\Core\Data;


interface EntityManagerInterface
{
    public function persist($object): void;
}