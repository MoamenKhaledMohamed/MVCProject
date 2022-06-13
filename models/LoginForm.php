<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'email' => [self::RULE_REQUIRE, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRE]
        ];
    }

    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function login(): bool
    {
        // get email with the same email that is in form Or false when failing.
        $user = (new User)->findOne(['email' => $this->email]);

        if(!$user){
           $this->addError('email', 'This Email Does Not  Exist.');
           return false;
        }
        if(!password_verify($this->password, $user->password)){
            $this->addError('password', 'This Password Is Not Correct.');
            return false;
        }

        return Application::$app->login($user);
    }
}