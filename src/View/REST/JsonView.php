<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View\REST;

class JsonView
{

    /**
     * @param  mixed  $data
     *
     * @return string
     */
    public function render($data): string
    {
        return json_encode($data);
    }
}
