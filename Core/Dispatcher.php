<?php

declare(strict_types = 1);

/**
 * Class Dispatcher.
 */
class Dispatcher
{
    /**
     * @var array
     */
    private $uri;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->uri = $this->parseUrl();
    }

    public function resolveUser()
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE id = " . $_SESSION['user']['id']);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Destroy user's session.
     */
    public function destroySession()
    {
        session_destroy();

        unset($_SESSION['user']);

        header("Location: /index");
    }

    /**
     * Set session for user.
     *
     * @param array $user
     */
    public function setSession(array $user)
    {
        $_SESSION['user'] = $user;
    }

    /**
     * Call specific controller action.
     *
     * @param Controller $controller
     * @param string $action
     */
    public function callController(Controller $controller, string $action = 'index')
    {
        $action = $this->resolveSession($action);

        call_user_func_array([$controller, $action], []);
    }

    /**
     * Return connection db resource.
     *
     * @param $host
     * @param $user
     * @param $password
     * @param $name
     *
     * @return PDO
     */
    public function getConnection($host, $user, $password, $name): PDO
    {
        $this->connection = Connection::getConnection($host, $user, $password, $name);

        return $this->connection;
    }

    /**
     * Get controller action name.
     *
     * @return string
     */
    public function getAction(): string
    {
        return '' === $this->uri[0] ? 'index' : $this->uri[0];
    }

    /**
     * Check if session data is set.
     *
     * @param string $action
     *
     * @return string
     */
    private function resolveSession(string $action): string
    {
        if (isset($_SESSION['user']) && !in_array($action, $this->middleware())) {
            header('Location: /home');
        } elseif (!isset($_SESSION['user']) && in_array($action, $this->middleware())) {
            header('Location: /index');
        }

        return $action;
    }

    /**
     * Parse request uri.
     *
     * @return array
     */
    private function parseUrl(): array
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (isset($uri)) {
            return explode('/', filter_var(trim($uri, '/')), FILTER_SANITIZE_URL);
        }
    }

    /**
     * Middleware for authorized pages.
     */
    private function middleware()
    {
        return [
            'home', 'upload',
        ];
    }
}
