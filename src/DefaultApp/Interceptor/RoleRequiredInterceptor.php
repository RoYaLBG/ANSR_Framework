<?php

namespace DefaultApp\Interceptor;


use ANSR\Core\Http\Component\RequestInterface;
use ANSR\Core\Http\Response\RedirectResponse;
use ANSR\Core\Http\Response\ResponseInterface;
use ANSR\Core\Interceptor\InterceptorAbstract;
use ANSR\Core\Service\Authentication\AuthenticationServiceInterface;
use ANSR\View\ViewInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component("2")
 */
class RoleRequiredInterceptor extends InterceptorAbstract
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var ViewInterface
     */
    private $view;


    public function __construct(AuthenticationServiceInterface $authenticationService,
                                ViewInterface $view)
    {
        $this->authenticationService = $authenticationService;
        $this->view = $view;
    }


    public function preHandle(RequestInterface $request,
                              ResponseInterface $response): ResponseInterface
    {
        if ($this->authenticationService->hasRole("ADMIN")) {
            return $response;
        }

        return new RedirectResponse($this->view->url("user_profile"));
    }
}