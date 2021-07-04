<?php

namespace Gornung\Webentwicklung\Exceptions;

use Exception;

class DatabaseException extends Exception
{

    /**
     * DatabaseException constructor.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  \Exception|null  $previous
     */
    public function __construct(string $message, int $code = 500, Exception $previous = null)
    {
        // TODO: Verificate if correct setted
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
