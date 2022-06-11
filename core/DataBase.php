<?php

namespace app\core;
use PDO;

class DataBase
{
    private \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir(Application::$ROOTPATH.'/migrations');
        $diffMigrations = array_diff($files, $appliedMigrations);
        $newMigrations = [];

        foreach ($diffMigrations as $migration){
            if($migration === '.' || $migration === '..')
                continue;
            $newMigrations[] = $migration;
            require_once Application::$ROOTPATH . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $this->log("Applying Migration $migration");
            $instance = new $className();
            $instance->up();
        }

        if(empty($newMigrations))
            $this->log("All Migrations Applied.");
        else
            $this->saveMigrations($newMigrations);
    }

    private function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `migrations`( 
        `id`  INT AUTO_INCREMENT,
        `migration` VARCHAR(100) NOT NULL, 
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    )");

    }

    private function getAppliedMigrations()
    {
        $sql = 'SELECT migration FROM migrations';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private function saveMigrations($migrations)
    {
       $values = implode(',', array_map(fn($m) =>"('$m')", $migrations));
       $sql = "INSERT INTO migrations (migration) VALUES $values;";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute();
    }
    private function log($message)
    {
        echo '[' . date('H:m:s') . ']' . $message . PHP_EOL;
    }
}