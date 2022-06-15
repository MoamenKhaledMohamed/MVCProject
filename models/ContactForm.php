<?php

namespace app\models;

use app\core\Model;

class ContactForm extends Model
{
    public string $subject = '';
    public string $email = '';
    public string $body = '';

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
           'subject' => [self::RULE_REQUIRE],
            'email' => [self::RULE_REQUIRE, self::RULE_EMAIL],
            'body' => [self::RULE_REQUIRE],
        ];
    }

    public function labels(): array
    {
        // TODO: Implement labels() method.
        return[
            'subject' => 'Subject',
            'email' => 'Email',
            'body' => 'Body',
        ];
    }

    public function send(): bool
    {
        return true;
    }
}