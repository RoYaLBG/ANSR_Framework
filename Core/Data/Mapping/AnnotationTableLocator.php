<?php

namespace ANSR\Core\Data\Mapping;


use ANSR\Core\Annotation\AnnotationInterface;
use ANSR\Core\Annotation\Parser\AnnotationParserInterface;
use ANSR\Core\Annotation\Type\Component;
use ANSR\Core\Annotation\Type\Id;
use ANSR\Core\Annotation\Type\Table;

/**
 * @Component
 */
class AnnotationTableLocator implements TableLocatorInterface
{
    const DEFAULT_PRIMARY_KEY = 'id';

    /**
     * @var AnnotationParserInterface
     */
    private $annotationParser;

    /**
     * AnnotationTableLocator constructor.
     * @param AnnotationParserInterface $annotationParser
     */
    public function __construct(AnnotationParserInterface $annotationParser)
    {
        $this->annotationParser = $annotationParser;
    }


    public function locateName(string $entityPath): string
    {
        $result = $this->annotationParser->parse(new \ReflectionClass($entityPath));
        $name = basename(Table::class);

        if (key_exists($name, $result) && !empty($result[$name])) {
            return $result[$name][0]->getValue();
        }

        return basename(strtolower($entityPath));
     }

    public function locatePrimaryKey(string $entityPath): string
    {
        $result = $this->annotationParser->parse(new \ReflectionClass($entityPath));
        $name = basename(Id::class);

        if (key_exists($name, $result) && !empty($result[$name])) {
            return $result[$name][0]->getValue();
        }

        return self::DEFAULT_PRIMARY_KEY;
    }
}