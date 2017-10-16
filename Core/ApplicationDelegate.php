<?php

namespace ANSR\Core;


interface ApplicationDelegate
{
    public function __invoke(Application $app);
}