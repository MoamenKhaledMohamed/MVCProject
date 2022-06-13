<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract function tableName(): string;

    abstract function attributes(): array;

    abstract function getPrimaryKey(): string;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $values = array_map(fn($atr) => ":$atr", $attributes);
        $sql = "INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (". implode(',', $values) .");";
        $stmt = self::prepare($sql);
        foreach ($attributes as $attribute)
        {
            $stmt->bindValue($attribute, $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    private static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public  function findOne($conditions) // [email => '', id => '']
    {
        $tableName = $this->tableName();
        $keys = array_keys($conditions);
        $whereClause = implode(' AND ', array_map(fn($k) => "$k = :$k", $keys));
        $sql = "SELECT * FROM $tableName WHERE $whereClause;";
        $stmt = self::prepare($sql);
        foreach ($conditions as $key => $condition)
            $stmt->bindValue(":$key", $condition);
        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }
}