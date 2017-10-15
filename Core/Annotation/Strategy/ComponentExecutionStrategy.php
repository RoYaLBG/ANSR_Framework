<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class ComponentExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'components.php';

    /**
     * @var Component
     */
    protected $annotation;

    public function execute()
    {
        /** @var PathConfigInterface $config */
        $config = $this->container->resolve(PathConfigInterface::class);
        $cacheFile = $config->getCacheDir()
            . DIRECTORY_SEPARATOR
            . self::CACHE_FILE;

        $components = [];
        if (file_exists($cacheFile)) {
            $components = include($cacheFile);
            if (!is_array($components)) {
                $components = [];
            }
        }

        $concrete = $this->annotation->getAnnotatedClass();
        $concreteInfo = new \ReflectionClass($concrete->getName());
        $priority = empty($this->annotation->getValue())
            ? 0
            : intval($this->annotation->getValue());

        foreach ($concreteInfo->getInterfaces() as $abstraction) {
            $concretes = &$components[$abstraction->getName()];
            if (null == $concretes) {
                $concretes = [];
            }

            if (array_key_exists($priority, $concretes) && $concretes[$priority] != $concrete->getName()) {
                throw new \Exception('More than one implementation of the same abstraction has the same priority');
            }

            $concretes[$priority] = $concrete->getName();
        }

        $data = var_export($components, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}