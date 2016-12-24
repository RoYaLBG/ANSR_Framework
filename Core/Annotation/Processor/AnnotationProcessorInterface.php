<?php

namespace ANSR\Core\Annotation\Processor;


interface AnnotationProcessorInterface
{
    public function process(array $directories = []);
}