<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\View\BlogPost;

use Gornung\Webentwicklung\View\AbstractView;

class Add extends AbstractView
{

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return '/view/templates/blog/add.html';
    }
}
