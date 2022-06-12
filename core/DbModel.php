<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract function tableName(): string;

    abstract function attributes(): array;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $values = array_map(fn($atr) => ":$atr", $attributes);
        $sql = "INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (". implode(',', $values) .");";
        $stmt = $this->prepare($sql);
        foreach ($attributes as $attribute)
        {
            $stmt->bindValue($attribute, $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    private function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}