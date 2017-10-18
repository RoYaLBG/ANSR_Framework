<?php

namespace ANSR\Core\Annotation;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class AnnotatedFileInfo
{
    private $usingSuffixes = [];

    public function addUsing($usingSuffix, string $usingStatement)
    {
        if (!array_key_exists($usingSuffix, $this->usingSuffixes)) {
            $this->usingSuffixes[$usingSuffix] = [];
        }

        $this->usingSuffixes[$usingSuffix][] = $usingStatement;
    }

    public function getUsings()
    {
        return $this->getUsings();
    }

    public function getUsingsBySuffix(string $suffix)
    {
        if (!array_key_exists($suffix, $this->usingSuffixes)) {
            return null;
        }

        return $this->usingSuffixes[$suffix];
    }
}