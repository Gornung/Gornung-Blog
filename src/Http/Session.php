<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Http;

class Session
{

    protected const LOGIN_INDICATOR_KEY = 'isLoggedIn';

    /**
     * @var array
     */
    protected array $defaultOptions = [
      'cookie_httponly' => true,
    ];

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return session_destroy();
    }

    /**
     * @param  array  $options
     *
     * @return bool
     */
    public function start(array $options = []): bool
    {
        return session_start($options + $this->defaultOptions);
    }

    /**
     *
     */
    public function login(): void
    {
        $this->setEntry(static::LOGIN_INDICATOR_KEY, true);
    }

    /**
     * @param  string  $name
     * @param  mixed  $entry
     */
    public function setEntry(string $name, $entry): void
    {
        $_SESSION[$name] = $entry;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->hasEntry(static::LOGIN_INDICATOR_KEY);
    }

    /**
     * @param  string  $name
     *
     * @return bool
     */
    public function hasEntry(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @return array
     */
    public function getEntries(): array
    {
        return $_SESSION;
    }

    /**
     * @param  string  $name
     *
     * can be bool or string supported in php 8.0
     * bool|string
     *
     * @return mixed
     */
    public function getEntry(string $name)
    {
        return $_SESSION[$name];
    }

    /**
     * @param  array  $entries
     */
    public function setEntries(array $entries): void
    {
        $_SESSION = $entries;
    }
}
