<?php

declare(strict_types = 1);


class Connection
{
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
