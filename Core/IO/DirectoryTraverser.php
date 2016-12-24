<?php

namespace ANSR\Core\IO;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DirectoryTraverser
{
    /**
     * @param $directory
     * @return \Generator
     */
    public static function findApplicationClasses($directory)
    {
        $iterator = dir($directory);
        $handle = $iterator->handle;

        while ($file = $iterator->read($handle)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $baseName = $file;

            $fullName = $directory . DIRECTORY_SEPARATOR . $baseName;
            if (is_dir($fullName)) {
                yield from self::findApplicationClasses($fullName);
            } else {

                $className = str_replace(".php", "", $fullName);
                $className = ltrim($className, '.');
                $className = str_replace(DIRECTORY_SEPARATOR, "\\", $className);

                yield $className;
            }
        }

        $iterator->close($handle);
    }
}