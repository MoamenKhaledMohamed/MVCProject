<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRE = 'require';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];

    public function loadData($data)
    {
        // initialize data to properties of class
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public abstract function rules() : array;

    public abstract  function labels() : array;

    public function getLabels($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules){
            $property = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if(is_array($rule))
                    $ruleName = $rule[0];
                if($ruleName === self::RULE_REQUIRE && !$property)
                    $this->addErrorWithRule($ruleName, $attribute);
                if($ruleName === self::RULE_EMAIL && !filter_var($property, FILTER_VALIDATE_EMAIL))
                    $this->addErrorWithRule($ruleName, $attribute);
                if($ruleName === self::RULE_MIN && strlen($property) < $rule['min'])
                    $this->addErrorWithRule($ruleName, $attribute, $rule);
                if($ruleName === self::RULE_MAX && strlen($property) > $rule['max'])
                    $this->addErrorWithRule($ruleName, $attribute, $rule);
                if($ruleName === self::RULE_MATCH && $property !== $this->{$rule['match']}){
                    $rule['match'] = $this->getLabels($rule['match']);
                    $this->addErrorWithRule($ruleName, $attribute, $rule);
                }
                if($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $sql = "SELECT * FROM $tableName WHERE $uniqueAttribute = :$uniqueAttribute";
                    $stmt = Application::$app->db->prepare($sql);
                    $stmt->bindValue($uniqueAttribute, $property);
                    $stmt->execute();
                    $result = $stmt->fetchObject();
                    if($result)
                        $this->addErrorWithRule($ruleName, $attribute, ['field' => $this->getLabels($attribute)]);
                }
            }
        }
        return empty($this->errors);
    }

    public function addErrorWithRule(string $ruleName, string $attribute, array $params = [])
    {
        $message = $this->getMessageError()[$ruleName];
        foreach ($params as $key => $value)
            $message = str_replace("{".$key."}", $value, $message);
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
       $this->errors[$attribute][] = $message;
    }
    public function getMessageError(): array
    {
        return [
            self::RULE_REQUIRE => "The Filed is required",
            self::RULE_EMAIL => "The Email is not valid",
            self::RULE_MIN => "The Filed must greater then {min}",
            self::RULE_MAX => "The Filed must less then {max}",
            self::RULE_MATCH => "The Filed must same {match}",
            self::RULE_UNIQUE => "The {field} is already exits",
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }
}