<?php

namespace ANSR\Core;


interface WebApplicationProducerInterface
{
    public function __invoke(): WebApplication;
}