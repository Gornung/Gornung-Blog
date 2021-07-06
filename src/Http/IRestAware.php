<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

interface IRestAware
{

    /**
     * @return array
     */
    public function getIdentifiers(): array;

    /**
     * @param array $identifiers
     */
    public function setIdentifiers(array $identifiers): void;
}
