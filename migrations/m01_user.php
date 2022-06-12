<?php

class m01_user
{
    public function up()
    {
       \app\core\Application::$app->db->pdo->exec("CREATE TABLE users (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100),
            email VARCHAR(100),
            password VARCHAR(100), 
            status INT 
            ) ENGINE=InnoDB;");
    }

    public function down()
    {

    }
}