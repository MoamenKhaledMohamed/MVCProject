<?php
namespace app\models;
use app\core\DbModel;

class User extends DbModel
{
    private const STATUS_INACTIVE = 0;
    private const STATUS_DELETED = 1;
    public string $full_name = '';
    public string $email = '';
    public string $password = '';
    public string $confirm_password = '';
    public int $status = self::STATUS_INACTIVE;

    // create a record in database.
    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'full_name' => [self::RULE_REQUIRE],
            'email' => [self::RULE_REQUIRE, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class],],
            'password' => [self::RULE_REQUIRE, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 9]],
            'confirm_password' => [self::RULE_REQUIRE, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 9], [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

     function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'users';
    }

    // name of cols in database
    function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'full_name',
            'email',
            'password',
            'status'
        ];
    }


    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            'full_name' => 'Full Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
        ];
    }
}