<?php

namespace ANSR\Core\Annotation\Processor;



use ANSR\Config\Cache\CacheConfigInterface;
use ANSR\Config\Path\PathConfigInterface;
use ANSR\Core\Annotation\Parser\AnnotationParserInterface;
use ANSR\Core\Annotation\Strategy\AnnotationExecutionStrategyFactoryInterface;
use ANSR\Core\Application;
use ANSR\Core\WebApplication;
use ANSR\Core\IO\DirectoryTraverser;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class DefaultAnnotationProcessor implements AnnotationProcessorInterface
{
    /**
     * @var CacheConfigInterface
     */
    private $cacheConfig;

    /**
     * @var PathConfigInterface
     */
    private $pathConfig;

    /**
     * @var AnnotationParserInterface
     */
    private $annotationParser;

    /**
     * @var AnnotationExecutionStrategyFactoryInterface
     */
    private $strategyFactory;

    public function __construct(CacheConfigInterface $cacheConfig,
                                PathConfigInterface $pathConfig,
                                AnnotationParserInterface $annotationParser,
                                AnnotationExecutionStrategyFactoryInterface $strategyFactory)
    {
        $this->cacheConfig = $cacheConfig;
        $this->pathConfig = $pathConfig;
        $this->annotationParser = $annotationParser;
        $this->strategyFactory = $strategyFactory;
    }


    public function process(array $directories = [])
    {
        $dirInfo = new \FilesystemIterator($this->pathConfig->getCacheDir());
        $isEmpty = $dirInfo->valid();

        if (!$isEmpty && !$this->cacheConfig->populateIfFilled()) {
            return;
        }

        foreach ($directories as $directory) {
            $this->processDirectory($directory);
        }
    }

    private function processDirectory($directory)
    {
        $junk = Application::APPLICATIONS_FOLDER;

        foreach (DirectoryTraverser::findApplicationClasses($directory) as $fileName) {
            $className = $fileName;
            if (strpos($fileName, $junk) === 0) {
                $className = str_replace($junk, "", $fileName);
            }

            try {
                if ($fileName[0] == DIRECTORY_SEPARATOR) {
                    $fileName = substr($fileName, 1, strlen($fileName)-1);
                }
                if (!is_readable($fileName . '.php')) {
                    continue;
                }
                $tokens = token_get_all(file_get_contents($fileName . '.php'));
                $isClass = false;
                foreach ($tokens as $token) {
                    if (is_array($token) && $token[0] == T_CLASS) {
                        $isClass = true;
                        break;
                    }
                }

                if (!$isClass) {
                    continue;
                }

                if (strpos($fileName, $directory) !== 0) {
                    $className =
                        DIRECTORY_SEPARATOR
                        . Application::VENDOR
                        . $className;
                }

                $refClass = new \ReflectionClass($className);

                $classAnnotations = $this->annotationParser->parse($refClass);

                foreach ($classAnnotations as $name => $annotationsByName) {
                    foreach ($annotationsByName as $annotation) {
                        $this->strategyFactory->create($name, $annotation)->execute();
                    }
                }
                foreach ($refClass->getMethods() as $method) {
                    $methodAnnotations = $this->annotationParser->parse($method);
                    foreach ($methodAnnotations as $name => $annotationsByName) {
                        foreach ($annotationsByName as $annotation) {
                            $this->strategyFactory->create($name, $annotation)->execute();
                        }
                    }
                }
            } catch (\Exception $e) {

            }
        }
    }

}