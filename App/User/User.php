<?php

namespace App\User;

class User {
    private $name;
    private $email;
    private $password;
    private $passwordConfirmation;

    private $errorMessage = [];

    public function createUser($name, $email, $password, $passwordConfirmation)
    {
        if(empty($name)){
            $this->setErrorMessage("Nome não pode ser vazio");
        }
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage[] = $message;
    }

    public function getErrorMessages()
    {
        return $this->errorMessage;
    }

    public function thereIsError()
    {
        return !empty($this->errorMessage);
    }
}