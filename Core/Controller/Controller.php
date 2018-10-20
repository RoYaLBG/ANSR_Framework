<?php

namespace ANSR\Core\Controller;


use ANSR\Core\Http\Component\SessionInterface;
use ANSR\Core\Http\Response\JsonResponse;
use ANSR\Core\Http\Response\RedirectResponse;
use ANSR\Core\Http\Response\ViewResponse;
use ANSR\Core\Service\Authentication\AuthenticationService;
use ANSR\Core\Service\Serialize\ObjectSerializerInterface;
use ANSR\View\ViewInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class Controller
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ObjectSerializerInterface
     */
    private $serializer;

    public function __construct(ViewInterface $view, SessionInterface $session, ObjectSerializerInterface $serializer)
    {
        $this->view = $view;
        $this->session = $session;
        $this->serializer = $serializer;
    }

    /**
     * @param string|null $model
     * @param string|null $viewName
     * @return ViewResponse
     */
    protected function view($model = null, $viewName = null)
    {
        return $this->view->render($model, $viewName);
    }

    /**
     * @param object|array $model
     * @return JsonResponse
     */
    protected function json($model)
    {
        return new JsonResponse($model, $this->serializer);
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    protected function redirect(string $url)
    {
        return new RedirectResponse($url);
    }

    /**
     * @param string $namedRoute
     * @param array ...$params
     * @return RedirectResponse
     */
    protected function redirectToRoute(string $namedRoute, ...$params)
    {
        $url = $this->view->url($namedRoute, $params);

        return $this->redirect($url);
    }

    /**
     * @param $key
     * @param array ...$messages
     */
    protected function addFlash($key, ...$messages)
    {
        foreach ($messages as $message) {
            $this->session->addFlashMessage($key, $message);
        }
    }

    protected function getId()
    {
        return $this->session->getAttribute(AuthenticationService::KEY_SESSION_USER_ID);
    }
}