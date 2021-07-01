<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Exceptions;

use Exception;

class NotFoundException extends Exception
{

    /**
     * @var string
     */
    protected $message = 'Die gesuchten Inhalte sind nicht verfügbar';

    /**
     * @var int
     */
    protected $code = 404;
}
