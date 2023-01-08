<?php
namespace App\User;

class User
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct($name, $email, $password, $password_confirmation)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, $password_confirmation);
        $this->createuser();
    }

    private function setName($name): void
    {
        $name = htmlspecialchars($name);
        $name = trim($name);
        
        if(empty($name)){
            Throw new \App\Exception\EmptyUserNameException;
        }

        if(strlen($name) < 3) {
            Throw new \LengthException("Nome precisa ser maior ou igual a 3 caracteres.");
        }

        if(strlen($name) > 256) {
            Throw new \LengthException("Nome precisa ser menor ou igual a 256 caracteres.");
        }

        $this->name = $name;
    }

    private function setEmail($email): void
    {
        $email = htmlspecialchars($email);
        $email = trim($email);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Throw new \App\Exception\InvalidEmailFormatException();
        }

        if(strlen($email) > 65) {
            Throw new \LengthException("Email precisa ser menor ou igual a 65 caracteres.");
        }

        $this->email = $email;
    }

    private function setPassword($password, $password_confirmation): void
    {
        if(strpos($password, ' ')) {
            Throw new \App\Exception\InvalidPasswordBlankCharacterException();
        }

        if(strlen($password) < 8) {
            Throw new \LengthException("Senha deve ter no mínimo 8 caracteres.");
        }

        if($password !== $password_confirmation) {
            Throw new \App\Exception\MismatchPasswordException();
        }

        $this->password = $password;
    }

    private function createUser(): void
    {
        $db = new \App\Database\Database();
        $db->insert('users', $this->getUserArray());
    }

    private function getUserArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}