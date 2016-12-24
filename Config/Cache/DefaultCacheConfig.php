<?php

namespace ANSR\Config\Cache;


class DefaultCacheConfig implements CacheConfigInterface
{

    public function populateIfFilled(): bool
    {
        $env = getenv('ENVIRONMENT');

        return $env && $env === 'dev';
    }
}