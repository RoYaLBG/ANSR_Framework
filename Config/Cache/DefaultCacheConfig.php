<?php

namespace ANSR\Config\Cache;


use ANSR\Core\Annotation\Type\Component;

/**
 * @Component
 */
class DefaultCacheConfig implements CacheConfigInterface
{

    public function populateIfFilled(): bool
    {
        $env = getenv('ENVIRONMENT');

        return $env && $env === 'dev';
    }
}