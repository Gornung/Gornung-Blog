<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View;

abstract class AbstractView
{

    /**
     *
     */
    protected const TEMPLATE_PLACEHOLDER_CONTENT = '{{content}}';

    /**
     * @param  mixed  $data
     *
     * @return string
     */
    public function render($data): string
    {
        // TODO need refactor using method to be type safe getting now objects and arrays can't make use of extract
        // maybe give multiple data values
        // extract($data);
        ob_start();
        /**
         * @psalm-suppress UnresolvableInclude
         */
        require dirname(dirname(__DIR__)) . $this->getBaseTemplatePath();
        $baseTemplate = ob_get_clean();
        ob_start();
        /**
         * @psalm-suppress UnresolvableInclude
         */
        require dirname(dirname(__DIR__)) . $this->getTemplatePath();
        $contentTemplate = ob_get_clean();

        return str_replace(
            static::TEMPLATE_PLACEHOLDER_CONTENT,
            $contentTemplate,
            $baseTemplate
        );
    }

    /**
     * @return string
     */
    protected function getBaseTemplatePath(): string
    {
        return '/view/templates/base.html';
    }

    /**
     * @return string
     */
    abstract protected function getTemplatePath(): string;
}
