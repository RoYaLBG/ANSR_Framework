<?php

namespace ANSR\Core\Service\Serialize;

interface ObjectSerializerInterface
{
    public function serialize($object): string;

    public function serializeRecursive($object): string;
}

