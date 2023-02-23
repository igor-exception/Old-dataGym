<?php
namespace App\User;

class User
{
    private string $name;
    private string $email;
    private string $password;
    private \App\Database\Database $database;

    public function __construct($name, $email, $password, $password_confirmation, \App\Database\Database $database)
    {
        $this->database = $database;
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password, $password_confirmation);
        $this->createUser();
    }

    private function setName($name): void
    {
        $name = self::validateName($name);

        $this->name = $name;
    }

    private function setEmail($email): void
    {
        $email = htmlspecialchars($email);
        $email = trim($email);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \App\Exception\InvalidEmailFormatException();
        }

        if(strlen($email) > 65) {
            throw new \LengthException("Email precisa ser menor ou igual a 65 caracteres.");
        }

        // verifica se ja existe mesmo email cadastrado, se tiver, da exception
        $already_exists = $this->database->search('users', ['fields' => ['email'], 'where' => ['email' => $email]]);
        
        if(count($already_exists) >= 1) {
            throw new \App\Exception\EmailAlreadyExists("Já possui uma conta registrada com este email.");
        }

        $this->email = $email;
    }

    private function setPassword($password, $password_confirmation): void
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

        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

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

    private function createUser(): void
    {
        $this->database->insert('users', $this->getUserArray());
    }

    private function getUserArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    public static function getUserById($id, \App\Database\Database $database): array
    {
        self::validateId($id);

        // verificar se o user existe
        // retornar infos do user
        $ret = $database->search('users', ['fields' => ['id', 'name', 'email'], 'where' => ['id' => $id]]);
        if(count($ret) < 1) {
            throw new \App\Exception\UserNotFoundException();
        }

        return [
            'id' => $ret[0]['id'],
            'name' => $ret[0]['name'],
            'email' => $ret[0]['email']
        ];
    }

    public static function validateId($id): string
    {
        $id = htmlspecialchars($id);
        $id = trim($id);

        if(empty($id)) {
            throw new \App\Exception\InvalidUserInfoException();
        }

        return $id;
    }

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

    public static function validatePassword($password, $password_confirmation = null): string
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

        $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

        return $password_encrypted;
    }

    public static function updateUser($id, $name, $password, $password_confirmation, \App\Database\Database $database, $session_user_id = null): bool
    {
        // verifica se o id do form é o mesmo que veio da sessão,
        // previne que tentem alterar cadastro de outro user
        if($id != $session_user_id) {
            throw new \App\Exception\InvalidUserInfoException();
        }

        $id = self::validateId($id);
        $name = self::validateName($name);
        $password = self::validatePassword($password, $password_confirmation);

        $user_info = $database->search('users', ['fields' => ['id', 'name', 'email'], 'where' => ['id' => $id]]);
        if(count($user_info) < 1) {
            throw new \App\Exception\UserNotFoundException();
        }

        // dara update apenas no que tiver de diferente
        $fields = [];
        if($user_info[0]['name'] != $name) {
            $fields['name'] = $name;
        }

        if(self::check_password($password, $user_info[0]['password'])) {
            $fields['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if(empty($fields)) {
            return false;
        }

        $ret = $database->update('users', ['update' => $fields, 'where' => ['id' => $id]]);

        return $ret;
    }

}