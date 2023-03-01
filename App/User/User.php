<?php
namespace App\User;

use \App\Validator\GeneralValidator;
use \App\Login\Login;

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
        $this->name = GeneralValidator::validateName($name);
    }

    private function setEmail($email): void
    {
        $email = GeneralValidator::validateEmail($email);

        GeneralValidator::validateEmailAvailable($email, $this);

        $this->email = $email;
    }

    public static function EmailAvailable($email, $database): bool
    {
        $ret = $database->search('users', [
            'fields' => ['email'],
            'where' => [
                'email' => $email]
            ]);
        
        if(count($ret) < 1) {
            return true;
        }

        return false;
    }

    private function setPassword($password, $password_confirmation): void
    {
        GeneralValidator::validatePassword($password, $password_confirmation);

        $this->password = password_hash($password, PASSWORD_DEFAULT);
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
        GeneralValidator::validateUserId($id);

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

    public static function updateUser($id, $name, $password, $password_confirmation, \App\Database\Database $database, $session_user_id = null): bool
    {
        // verifica se o id do form é o mesmo que veio da sessão,
        // previne que tentem alterar cadastro de outro user
        if($id != $session_user_id) {
            throw new \App\Exception\InvalidUserInfoException();
        }

        $id = GeneralValidator::validateUserId($id);
        $name = GeneralValidator::validateName($name);

        GeneralValidator::validatePassword($password, $password_confirmation);

        $user_info = $database->search('users', ['fields' => ['id', 'name', 'email', 'password'], 'where' => ['id' => $id]]);
        
        if(count($user_info) < 1) {
            throw new \App\Exception\UserNotFoundException();
        }

        // dara update apenas no que tiver de diferente
        $fields = [];
        if($user_info[0]['name'] != $name) {
            $fields['name'] = $name;
        }

        if(!Login::check_password($password, $user_info[0]['password'])) {
            $fields['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if(empty($fields)) {
            return false;
        }

        $ret = $database->update('users', ['update' => $fields, 'where' => ['id' => $id]]);

        return $ret;
    }
}