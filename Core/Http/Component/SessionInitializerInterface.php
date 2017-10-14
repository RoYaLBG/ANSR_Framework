<?php

namespace ANSR\Core\Http\Component;


interface SessionInitializerInterface
{
    /**
     * @return array The sessions bag reference
     */
    public function &__invoke(): array;
}