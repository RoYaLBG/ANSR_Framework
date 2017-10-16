<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Value;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class ValueExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'values.php';

    /**
     * @var Value
     */
    protected $annotation;

    public function execute()
    {
        /** @var PathConfigInterface $config */
        $config = $this->container->resolve(PathConfigInterface::class);
        $cacheFile = $config->getCacheDir()
            . DIRECTORY_SEPARATOR
            . self::CACHE_FILE;

        $values = [];
        if (file_exists($cacheFile)) {
            $values = include($cacheFile);
            if (!is_array($values)) {
                $values = [];
            }
        }

        $concrete = $this->annotation->getAnnotatedClass()->getName();
        if (!isset($values[$concrete])) {
            $values[$concrete] = [];
        }

        $values[$concrete][$this->annotation->getParam()] = $this->annotation->getValue();

        $data = var_export($values, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}