<?php

function getDbConnection()
{
    static $connection = null;
    static $envLoaded = false;

    if ($connection === null) {
        if (!$envLoaded && class_exists('Dotenv\\Dotenv')) {
            $projectRoot = dirname(__DIR__);
            $dotenv = Dotenv\Dotenv::createImmutable($projectRoot);
            $dotenv->safeLoad();
            $envLoaded = true;
        }

        $host = getenv('DB_HOST');
        if ($host === false || $host === null || $host === '') { $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost'; }

        $portEnv = getenv('DB_PORT');
        if ($portEnv === false || $portEnv === null || $portEnv === '') { $portEnv = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : 3306; }
        $port = (int)$portEnv;
        if ($port <= 0) { $port = 3306; }

        $user = getenv('DB_USERNAME');
        if ($user === false || $user === null) { $user = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root'; }

        $password = getenv('DB_PASSWORD');
        if ($password === false || $password === null) { $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : ''; }

        $dbname = getenv('DB_DATABASE');
        if ($dbname === false || $dbname === null || $dbname === '') { $dbname = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'blog_mvc'; }

        $connection = @new mysqli($host, $user, $password, $dbname, $port);
        if ($connection->connect_error) {
            die('Помилка підключення до БД: ' . $connection->connect_error);
        }

        if (!$connection->set_charset('utf8mb4')) {
            die('Не вдалося встановити кодування utf8mb4: ' . $connection->error);
        }
    }

    return $connection;
}
