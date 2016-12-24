<?php

namespace ANSR\Core\Annotation\Strategy;


use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Type\Auth;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class AuthExecutionStrategy extends ContainerAwareExecutionStrategy
{
    const CACHE_FILE = 'auth.php';

    /**
     * @var Auth
     */
    protected $annotation;

    public function execute()
    {
        /** @var PathConfigInterface $config */
        $config = $this->container->resolve(PathConfigInterface::class);
        $cacheFile = $config->getCacheDir()
            . DIRECTORY_SEPARATOR
            . self::CACHE_FILE;

        $auths = [];
        if (file_exists($cacheFile)) {
            $auths = include($cacheFile);
            if (!is_array($auths)) {
                $auths = [];
            }
        }

        $class = $this->annotation->getAnnotatedClass();
        $action = $this->annotation->getAnnotatedMethod();

        $auths[$class->getName()][$action->getName()] = array_map(
            function($role) { return trim($role); },
            explode(',', $this->annotation->getValue())
        );

        $data = var_export($auths, true);

        file_put_contents($cacheFile, '<?php return ' . $data . ';');
    }
}