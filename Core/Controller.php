<?php

declare(strict_types=1);

/**
 * Class Controller.
 */
class Controller
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(PDO $connection, Dispatcher $dispatcher)
    {
        $this->view = new View();
        $this->connection = $connection;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Set task as complete.
     */
    public function update()
    {
        try {
            $statement = $this->connection->prepare('UPDATE tasks SET is_complete = 1 WHERE id = :id');
            $statement->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage());
        }
    }

    /**
     * Show upload file.
     */
    public function upload()
    {
        if ($this->checkAction('upload')) {
            $this->uploadFile();
            $this->redirect('home');
        }

        $this->view->generate('upload.php');
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
        $user = $this->dispatcher->resolveUser();
        $permissions = $this->dispatcher->getPermissions();

        $statement =
            $this->connection->prepare("SELECT * FROM tasks WHERE is_complete = 0 and user_id = " . $user['id']);
        $statement->execute();

        $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);


        $this->view->generate('home.php', [
            'tasks'       => $tasks,
            'user'        => $user,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        $this->dispatcher->destroySession();
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

    /**
     * Upload file and insert date to db.
     */
    private function uploadFile()
    {
        $file = $_FILES['file']['tmp_name'];
        $uploadDir = dirname(__DIR__) . '/storage/';
        $uploadFile = $uploadDir . basename($file);
        $insertQuery = [];
        $insertData = [];

        if (move_uploaded_file($file, $uploadFile)) {
            $row = 0;

            if (($handle = fopen($uploadFile, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if ($row++ == 0) {
                        continue;
                    }

                    $insertQuery[] = '(?)';
                    $insertData[] = $data[0];
                }
            }

            $sql = "INSERT INTO tasks (name) VALUES ";
            $sql .= implode(', ', $insertQuery);

            try {
                $statement = $this->connection->prepare($sql);
                $statement->execute($insertData);
            } catch (PDOException $ex) {
                unlink($uploadFile);
            }

            unlink($uploadFile);
        }
    }

    /**
     * Login user
     *
     * @return bool
     */
    private function loginUser(): bool
    {
        try {
            $statement = $this
                ->connection
                ->prepare("SELECT * FROM users WHERE name = :name and password = :password");

            $statement->execute([
                ":name" => $_POST['name'],
                ":password" => md5($_POST['password'])
            ]);

            if ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
                $this->dispatcher->setSession($data);

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

            $this->dispatcher->setSession($_POST['name']);

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
