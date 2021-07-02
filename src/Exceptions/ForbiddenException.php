<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Exceptions;

use Exception;

class ForbiddenException extends Exception
{

    public function __construct($message, $code = 401, Exception $previous = null)
    {
        // TODO: Verificate if correct setted

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
