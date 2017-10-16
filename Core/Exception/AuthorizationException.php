<?php

namespace ANSR\Core\Exception;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
class AuthorizationException extends \Exception
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}