<?php

namespace App\User;

class User {
    private $name;
    private $email;
    private $password;

    private $errorMessages = [];

    public function __construct($name, $email, $password, $password_confirmation)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, $password_confirmation);
    }

    private function setName($name): void
    {
        $name = htmlspecialchars($name);
        if(empty($name)){
            $this->addError("Nome não pode ser vazio.");
        }

        if(strlen($name) < 3){
            $this->addError("Nome precisa ser maior ou igual a 3 caracteres.");
        }

        if(strlen($name) > 256){
            $this->addError("Nome precisa ser menor ou igual a 256 caracteres.");
        }

        $this->name = $name;
    }

    private function setEmail($email): void
    {
        $email = htmlspecialchars($email);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->addError("Email no formato inválido.");
        }

        if(strlen($email) > 65) {
            $this->addError("Email deve ser menor ou igual a 65 caracteres.");
        }

        $this->email = $email;
    }

    private function setPassword($password, $password_confirmation): void
    {
        if(strlen($password) < 8) {
            $this->addError("Senha deve ter no mínimo 8 caracteres.");
        }

        if($password !== $password_confirmation) {
            $this->addError("Senha e confirmação de senha devem ser iguais.");
        }

        $this->password = $password;
    }


    private function addError($error_message): void
    {
        $this->errorMessages[] = $error_message;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function thereIsErrors(): bool
    {
        return !empty($this->errorMessages);
    }
    
}