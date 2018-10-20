<?php

namespace ANSR\Core\Http\Response;
use ANSR\Core\Service\Serialize\ObjectSerializerInterface;


/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class JsonResponse implements ResponseInterface
{
    private $model;

    /**
     * @var ObjectSerializerInterface
     */
    private $serializer;

    private $recursive;


    public function __construct($model, ObjectSerializerInterface $serializer, $recursive = false)
    {
        $this->model = $model;
        $this->serializer = $serializer;
        $this->recursive = $recursive;
    }

    public function send()
    {
        header("Content-Type: application/json");
        if ($this->recursive) {
            echo $this->serializer->serializeRecursive($this->model);
        } else {
            echo $this->serializer->serialize($this->model);
        }
    }
}