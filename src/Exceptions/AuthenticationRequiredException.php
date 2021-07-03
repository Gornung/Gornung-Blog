<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Exceptions;

use Exception;

class AuthenticationRequiredException extends Exception
{

    /**
     * @var string
     */
    protected $message = 'Aktiver Login benötigt';

    /**
     * @var int
     */
    protected $code = 401;
}
