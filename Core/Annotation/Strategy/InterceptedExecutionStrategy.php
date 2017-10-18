<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Value;
use ANSR\Core\Interceptor\InterceptorInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class InterceptedExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'interceptors.php';

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

        $interceptors = [];
        if (file_exists($cacheFile)) {
            $interceptors = include($cacheFile);
            if (!is_array($interceptors)) {
                $interceptors = [];
            }
        }

        $fileInfo = $this->annotation->getFileInfo();

        $class = $this->annotation->getAnnotatedClass()->getName();
        $method = $this->annotation->getAnnotatedMethod()->getName();

        if (!array_key_exists($class, $interceptors)) {
            $interceptors[$class] = [];
        }

        if (!array_key_exists($method, $interceptors[$class])) {
            $interceptors[$class][$method] = [];
        }

        $values = explode(',', $this->annotation->getValue());
        foreach ($values as $value) {
            $value = trim($value);
            $relevantUsings = $fileInfo->getUsingsBySuffix($value);
            if (!class_exists($value) && null === $relevantUsings) {
                throw new \Exception("Unknown interceptor registered. Did you forget an using statement?");
            }

            $relevantInterceptors = array_filter($relevantUsings, function ($using) {
                $info = new \ReflectionClass($using);
                return in_array(InterceptorInterface::class, $info->getInterfaceNames());
            });

            $interceptors[$class][$method] = array_merge($interceptors[$class][$method], $relevantInterceptors);
        }

        $interceptors[$class][$method] = array_unique($interceptors[$class][$method]);

        $data = var_export($interceptors, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}