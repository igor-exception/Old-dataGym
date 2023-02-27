<?php

namespace App\Login;

class Login {
    public static function login($email, $password, \App\Database\Database $database): array
    {
        if(empty($email) || empty($password)) {
            throw new \App\Exception\InvalidEmailOrPassword("Email ou senha inválidos.");
        }

        $ret = $database->search('users', ['fields' => ['id', 'name', 'password'], 'where' => ['email' => $email]]);

        if(count($ret) < 1) {
            throw new \App\Exception\InvalidEmailOrPassword("Email ou senha inválidos.");
        }

        $verified = self::check_password($password, $ret[0]['password']);
        if(!$verified) {
            throw new \App\Exception\InvalidEmailOrPassword("Email ou senha inválidos.");
        }

        return [
            'name' => $ret[0]['name'],
            'email' => $email,
            'id' => $ret[0]['id']
        ];
    }

    public static function check_password($received_password, $hash): bool
    {
        if(!password_verify($received_password, $hash)){
            return false;
        }

        return true;
    }
}