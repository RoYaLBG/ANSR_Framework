<?php

namespace ANSR\Config\Cache;


use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
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