<?php

declare(strict_types = 1);

class Dispatcher
{
    private $uri;

    public function __construct()
    {
        $this->uri = $this->parseUrl();
    }

    public function getConnection($host, $user, $password, $name)
    {
        return Connection::getConnection($host, $user, $password, $name);
    }

    /**
     * @return string
     */
    public function getAtcion(): string
    {
        return $this->uri[0];
    }

    /**
     * @return array
     */
    private function parseUrl(): array
    {
        $uri = $_SERVER['REQUEST_URI'];

        if(isset($uri)) {
            return explode('/', filter_var(trim($uri, '/')), FILTER_SANITIZE_URL);
        }
    }
}