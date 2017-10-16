<?php

namespace ANSR\Core\Http\Response;


use ANSR\View\ViewInterface;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class ViewResponse implements ResponseInterface
{
    private $viewFile;

    private $model;

    /**
     * @var ViewInterface
     */
    private $view;

    public function __construct($viewFile,
                                ViewInterface $view,
                                $model)
    {
        $this->viewFile = $viewFile;
        $this->view = $view;
        $this->model = $model;
    }

    public function send()
    {
        $view = $this->view;
        $model = $this->model;
        ob_start();
        include($this->viewFile);
        $content = ob_get_clean();

        echo $content;

        $this->view->flushFlashMessages();
    }
}