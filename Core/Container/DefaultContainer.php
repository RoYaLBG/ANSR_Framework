<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 12/22/2016
 * Time: 7:23 PM
 */

namespace ANSR\Core\Container;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultContainer implements ContainerInterface
{
    /**
     * @var string[]
     */
    private $dependencies = [];

    /**
     * @var object[]
     */
    private $resolvedDependencies = [];

    public function registerDependency(string $abstraction, string $implementation)
    {
        $this->dependencies[$abstraction] = $implementation;
    }

    public function addBean(string $abstraction, $object)
    {
        $this->dependencies[$abstraction] = get_class($object);
        $this->resolvedDependencies[get_class($object)] = $object;
        $this->resolvedDependencies[$abstraction] = $object;
    }

    public function resolve($className, $interfaceName = null)
    {
        if (array_key_exists($className, $this->resolvedDependencies)) {
            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        if ($refClass->isInterface()) {
            $interfaceName = $className;
            $className = $this->dependencies[$interfaceName];
            if (array_key_exists($className, $this->resolvedDependencies)) {
                return $this->resolvedDependencies[$className];
            }
            $refClass = new \ReflectionClass($className);
        }

        $constructor = $refClass->getConstructor();

        if ($constructor === null) {
            $object = new $className;

            $this->resolvedDependencies[$className] = $object;

            return $object;
        }

        $parameters = $constructor->getParameters();

        $arguments = [];
        foreach ($parameters as $parameter) {
            $dependencyInterface = $parameter->getClass();
            $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
            $arguments[] = $this->resolve($dependencyClass, $dependencyInterface->getName());
        }

        $object = $refClass->newInstanceArgs($arguments);
        if ($interfaceName == null) {
            $interfaceName = $className;
        }
        $this->addBean($interfaceName, $object);

        return $object;
    }

    public function getDependency($abstraction)
    {
        return $this->dependencies[$abstraction];
    }

    public function exists($abstraction): bool
    {
        return array_key_exists($abstraction, $this->dependencies);
    }
}