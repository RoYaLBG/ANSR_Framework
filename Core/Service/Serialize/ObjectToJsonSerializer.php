<?php

namespace ANSR\Core\Service\Serialize;

use ANSR\Core\Annotation\Parser\AnnotationParserInterface;
use ANSR\Core\Annotation\Type\Component;
use ANSR\Core\Annotation\Type\ResponseExclude;


/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class ObjectToJsonSerializer implements ObjectSerializerInterface
{

    /**
     * @var AnnotationParserInterface
     */
    private $annotationParser;

    /**
     * ObjectToJsonSerializer constructor.
     * @param AnnotationParserInterface $annotationParser
     */
    public function __construct(AnnotationParserInterface $annotationParser)
    {
        $this->annotationParser = $annotationParser;
    }


    public function serialize($object): string
    {
        if (!is_array($object)) {
            return json_encode($this->serializeIndirect($object));
        }

        $result = [];
        foreach ($object as $entity) {
            $result[] = $this->serializeIndirect($entity);
        }

        return json_encode($result);

    }

    public function serializeRecursive($object): string
    {
        if (!is_array($object)) {
            return json_encode($this->serializeIndirect($object, true));
        }

        $result = [];
        foreach ($object as $entity) {
            $result[] = $this->serializeIndirect($entity, true);
        }

        return json_encode($result);
    }

    private function serializeIndirect($object, $recursive = false, &$result = [], $visited = []): array
    {
        $classInfo = new \ReflectionClass($object);
        foreach ($classInfo->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            if (strpos($methodName, 'get') !== 0) {
                continue;
            }

            $annotations = $this->annotationParser->parse($method);
            if (array_key_exists(basename(ResponseExclude::class), $annotations)) {
                continue;
            }

            $property = strtolower(substr($methodName, 3));
            $value = $method->invoke($object);
            if (is_object($value) && $recursive && !in_array($value, $visited)) {
                $visited[] = $value;
                $result[$property] = [];
                $result[$property] = $this->serializeIndirect($value, true, $result[$property], $visited);
            } else if (!is_object($value)) {
                $result[$property] = $value;
            }
        }

        return $result;
    }
}

