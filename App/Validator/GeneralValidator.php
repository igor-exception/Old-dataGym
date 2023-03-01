<?php

namespace App\Validator;

class GeneralValidator {

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

    public static function validateEmailAvailable($email, \App\Database\Database $database): void
    {
        $ret = \App\User\User::EmailAvailable($email, $database);
        
        if(!$ret) {
            throw new \App\Exception\EmailAlreadyExists("Já possui uma conta registrada com este email.");
        }
    }

    public static function validateUserId($id): string
    {
        $id = htmlspecialchars($id);
        $id = trim($id);

        if(empty($id)) {
            throw new \App\Exception\InvalidUserInfoException();
        }

        return $id;
    }

    public static function validateExerciseId($id): string
    {
        $id = htmlspecialchars($id);
        $id = trim($id);

        if(empty($id)) {
            throw new \App\Exception\InvalidExerciseInfoException();
        }

        return $id;
    }

    public static function validateExerciseName($name): string
    {
        $name = htmlspecialchars($name);
        $name = trim($name);

        if(empty($name)) {
            throw new \App\Exception\EmptyExerciseNameException();
        }

        if(strlen($name) <= 2) {
            throw new \LengthException('Nome muito curto. Precisa ser maior que 2 caracteres.');
        }

        if(strlen($name) > 200) {
            throw new \LengthException('Nome muito Longo. Precisa ser menor que 200 caracteres.');
        }

        return $name;
    }

    public static function validateExerciseDescription($description): string
    {
        $description = htmlspecialchars($description);
        $description = trim($description);

        if(strlen($description) > 65000) {
            throw new \LengthException('Descrição muito Longa. Precisa ser menor que 65.000 caracteres.');
        }

        return $description;
    }

    public static function validateExerciseIdExists($id, \App\Database\Database $database): void
    {
        \App\Exercise\Exercise::getExercise($id, $database);
    }
}