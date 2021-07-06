<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class RestRequest extends Request implements IRestAware
{
    protected array $identifiers;

    /**
     * @param  \Gornung\Webentwicklung\Http\IRequest  $request
     *
     * @return \Gornung\Webentwicklung\Http\RestRequest
     */
    public static function fromRequestInstance(IRequest $request): RestRequest
    {
        return new static(
            $request->getUrl(),
            $request->getParameters(),
            $request->getMethode()
        );
    }

    /**
     * @return array
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    /**
     * @param  array  $identifiers
     */
    public function setIdentifiers(array $identifiers): void
    {
        $this->identifiers = $identifiers;
    }
}
