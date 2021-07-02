<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View;

abstract class AbstractView
{

    /**
     * @param  mixed  $data
     *
     * @return string
     */
    public function render($data): string
    {
        extract($data->toArray);
        ob_start();
        require dirname(dirname(__DIR__)) . $this->getTemplatePath();
        return ob_get_clean();
    }

    /**
     * @return string
     */
    abstract protected function getTemplatePath(): string;
}
