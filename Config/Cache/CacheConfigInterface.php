<?php

namespace ANSR\Config\Cache;


interface CacheConfigInterface
{
    public function populateIfFilled(): bool;
}