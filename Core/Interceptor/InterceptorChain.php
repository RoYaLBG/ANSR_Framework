<?php

namespace ANSR\Core\Interceptor;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class InterceptorChain implements InterceptorChainInterface
{
    /**
     * @var InterceptorInterface[]
     */
    private $interceptors;

    private $position;

    public function __construct(array $interceptors)
    {
        $this->interceptors = $interceptors;
        $this->position = 0;
    }

    public function current()
    {
        if ($this->position >= count($this->interceptors)) {
            return null;
        }

        return $this->interceptors[$this->position];
    }

    public function moveNext()
    {
        $this->position++;
    }
}