<?php

declare(strict_types = 1);

/**
 * Class Connection.
 */
class Connection
{
    /**
     * Return connection resource.
     *
     * @param $host
     * @param $user
     * @param $password
     * @param $name
     *
     * @return PDO
     */
    public static function getConnection($host, $user, $password, $name)
    {
        try {
            $connection = new PDO("mysql:host={$host};dbname={$name}", $user, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }

        return $connection;
    }
}
