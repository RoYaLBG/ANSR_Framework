<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Value;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class IdExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'primary_keys.php';

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

        $values[$this->annotation->getAnnotatedClass()->getName()] = $this->annotation->getValue();

        $data = var_export($values, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}