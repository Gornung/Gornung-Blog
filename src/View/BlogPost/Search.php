<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View\BlogPost;

use Gornung\Webentwicklung\View\AbstractView;

class Search extends AbstractView
{

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return '/view/templates/blog/search.html';
    }
}
