<?php

namespace ANSR\Config\Path;


use ANSR\Core\Annotation\Type\Component;
use ANSR\Core\Annotation\Type\Value;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class PathConfig implements PathConfigInterface
{
    private $cacheDir;

    /** @Value("cache.dir", param="cacheDir") */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }
}