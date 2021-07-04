<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Exceptions;

use Exception;

class ForbiddenException extends Exception
{

    /**
     * @var string
     */
    protected $message = 'Sie sind dazu nicht berechtigt.';

    /**
     * @var int
     */
    protected $code = 403;
}
