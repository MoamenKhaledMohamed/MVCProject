<?php
namespace app\models;
use app\core\Model;

class RegisterModel extends Model
{
    public string $full_name = '';
    public string $email = '';
    public string $password = '';
    public string $confirm_password = '';

    // create a record in database.
    public function regsiter()
    {

    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'full_name' => [self::RULE_REQUIRE],
            'email' => [self::RULE_REQUIRE, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRE, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 9]],
            'confirm_password' => [self::RULE_REQUIRE, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 9], [self::RULE_MATCH, 'match' => 'password']]
        ];
    }
}