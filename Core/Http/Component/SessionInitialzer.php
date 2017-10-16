<?php

namespace ANSR\Core\Http\Component;

use ANSR\Core\Annotation\Type\Component;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 *
 * @Component
 */
class SessionInitialzer implements SessionInitializerInterface
{
    public function &__invoke(): array
    {
        session_start();
        return $_SESSION;
    }
}