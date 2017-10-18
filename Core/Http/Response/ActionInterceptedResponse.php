<?php

namespace ANSR\Core\Http\Response;


use ANSR\Core\ActionInterceptedDelegate;
use ANSR\Core\Interceptor\InterceptorChainInterface;
use ANSR\Core\Http\Component\RequestInterface;


/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class ActionInterceptedResponse implements ResponseInterface
{
    /**
     * @var InterceptorChainInterface
     */
    private $chain;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var callable|ActionInterceptedDelegate
     */
    private $action;

    public function __construct(
        InterceptorChainInterface $chain,
        RequestInterface $request,
        $action)
    {
        $this->chain = $chain;
        $this->request = $request;
        $this->action = $action;
    }


    public function send()
    {
        $interceptor = $this->chain->current();
        $response = null;
        if (null === $interceptor) {
            $action = $this->action;
            $response = $action();
        } else {
            $this->chain->moveNext();
            $response = $interceptor->preHandle($this->request, $this);
        }

        $response->send();
    }
}