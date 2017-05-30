<?php

declare(strict_types = 1);

class Dispatcher
{
    private $uri;

    public function __construct()
    {
        $this->uri = $this->parseUrl();
    }

    /**
     * @param string $user
     */
    public function setSession(string $user)
    {
        $_SESSION['user'] = $user;
    }

    /**
     * @param Controller $controller
     * @param string $action
     */
    public function callController(Controller $controller, string $action = 'index')
    {
        $action = $this->resolveSession($action);

        call_user_func_array([$controller, $action], []);
    }

    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $name
     *
     * @return PDO
     */
    public function getConnection($host, $user, $password, $name)
    {
        return Connection::getConnection($host, $user, $password, $name);
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return '' === $this->uri[0] ? 'index' : $this->uri[0];
    }

    private function resolveSession(string $action)
    {
        if (isset($_SESSION['user']) && $action !== 'home') {
            header('Location: /home');
        } elseif (!isset($_SESSION['user']) && $action === 'home') {
            header('Location: /index');
        }

        return $action;
    }

    /**
     * @return array
     */
    private function parseUrl(): array
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (isset($uri)) {
            return explode('/', filter_var(trim($uri, '/')), FILTER_SANITIZE_URL);
        }
    }
}
