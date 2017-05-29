<?php

declare(strict_types = 1);

/**
 * Class Controller.
 */
class Controller
{
    private $view;
    private $connection;

    public function __construct($connection)
    {
        $this->view = new View();
        $this->connection = $connection;
    }

    /**
     * Show index page.
     */
    public function index()
    {
        $this->view->generate('index.php');
    }

    /**
     * Show home page.
     */
    public function home()
    {
        $statement = $this->connection->prepare("SELECT * FROM tasks");
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->view->generate('home.php', $data);
    }

    /**
     * Show login page.
     */
    public function login()
    {
        if ($this->checkAction('login')) {
            if ($this->loginUser()) {
                $this->redirect('home');
            } else {
                $this->redirect('index');
            }
        }

        $this->view->generate('login.php');
    }

    /**
     * Show register page.
     */
    public function register()
    {
        if ($this->checkAction('register')) {
            if ($this->createUser()) {
                $this->redirect('home');
            } else {
                $this->redirect('index');
            }
        }

        $this->view->generate('register.php');
    }

    private function loginUser()
    {
        try {
            $statement = $this
                ->connection
                ->prepare("SELECT * FROM users WHERE name = :name and password = :password");

            $statement->execute([
                ":name" => $_POST['name'],
                ":password" => md5($_POST['password'])
            ]);

            if (null !== $statement->fetch(PDO::FETCH_ASSOC)) {
                return true;
            }

            return false;
        } catch (PDOException $ex) {
            return false;
        }
    }

    /**
     * Store user in DB.
     *
     * @return bool
     */
    private function createUser(): bool
    {
        try {
            $statement = $this
                ->connection
                ->prepare("INSERT INTO users (name, password, member_id) VALUES (:name, :password, :member)");

            $statement->bindparam(":name", $_POST['name']);
            $statement->bindparam(":password", md5($_POST['password']));
            $statement->bindparam(":member", $_POST['member']);

            $statement->execute();

            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    /**
     * Check if action exist.
     *
     * @param string $action
     * @return bool
     */
    private function checkAction(string $action): bool
    {
        return isset($_POST[$action]);
    }

    /**
     * Redirect helper.
     *
     * @param string $path
     */
    public function redirect(string $path)
    {
        header("Location: /{$path}");
    }
}