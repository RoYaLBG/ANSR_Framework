<?php

namespace ANSR\Config\Path;

class PathConfig implements PathConfigInterface
{
    private $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }
}