<?php

namespace ANSR\View;

use ANSR\Core\Http\Response\ViewResponse;

interface ViewInterface
{
    public function render($model = null, $viewName = null): ViewResponse;

    public function url($namedRoute, ...$params);

    public function flushFlashMessages();

    public function getFlash($key);
}


