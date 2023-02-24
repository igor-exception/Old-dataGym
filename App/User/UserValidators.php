<?php

namespace App\User;

class UserValidators {
    public static function validateName($name): string
    {
        $name = htmlspecialchars($name);
        $name = trim($name);
        
        if(empty($name)){
            throw new \App\Exception\EmptyUserNameException;
        }

        if(strlen($name) < 3) {
            throw new \LengthException("Nome precisa ser maior ou igual a 3 caracteres.");
        }

        if(strlen($name) > 255) {
            throw new \LengthException("Nome precisa ser menor ou igual a 255 caracteres.");
        }

        return $name;
    }

    public static function validateEmail($email): string
    {
        $email = htmlspecialchars($email);
        $email = trim($email);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \App\Exception\InvalidEmailFormatException();
        }

        if(strlen($email) > 65) {
            throw new \LengthException("Email precisa ser menor ou igual a 65 caracteres.");
        }

        return $email;
    }
    
    public static function validatePassword($password, $password_confirmation = null): void
    {
        if(strpos($password, ' ')) {
            throw new \App\Exception\InvalidPasswordBlankCharacterException();
        }

        if(strlen($password) < 8) {
            throw new \LengthException("Senha deve ter no mínimo 8 caracteres.");
        }

        if(strlen($password) > 255) {
            throw new \LengthException("Senha deve ter no máximo 255 caracteres.");
        }

        if($password !== $password_confirmation) {
            throw new \App\Exception\MismatchPasswordException();
        }
    }

}