<?php

namespace Tests\Unit\App\User;

class UserTest extends \PHPUnit\Framework\TestCase
{
    private $name = 'John';
    private $email = 'john.doe@gmail.com';
    private $password = '12345678';
    private $password_confirmation = '12345678';

    public function test_create_a_valid_user()
    {
        $user = new \App\User\User($this->name, 
                                   $this->email,
                                   $this->password,
                                   $this->password_confirmation);

        $this->assertFalse($user->thereIsErrors());
    }

    public function test_an_empty_name_should_get_an_error()
    {
        $user = new \App\User\User('',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);

        $this->assertContains("Nome não pode ser vazio.", $user->getErrorMessages());
    }

    public function test_a_short_name_should_get_an_error(){
        $user = new \App\User\User(
                                    'Jo',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);

        $this->assertContains('Nome precisa ser maior ou igual a 3 caracteres.', $user->getErrorMessages());
    }

    public function test_a_big_name_should_get_an_error() {
        $user = new \App\User\User(
                                    'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);
        
        $this->assertContains("Nome precisa ser menor ou igual a 256 caracteres.", $user->getErrorMessages());
    }

    public function test_a_invalid_email_should_get_an_error() {
        $user = new \App\User\User(
                                    $this->name,
                                    'john.doe.com',
                                    $this->password,
                                    $this->password_confirmation);
        $this->assertContains("Email no formato inválido.", $user->getErrorMessages());
    }

    public function test_a_big_email_should_get_an_error() {
        $user = new \App\User\User(
                                $this->name,
                                '66charssssssssssssssssssssssssssssssssssssssssssssssssss@gmail.com',
                                $this->password,
                                $this->password_confirmation);
        
        $this->assertContains("Email deve ser menor ou igual a 65 caracteres.", $user->getErrorMessages());
    }

    public function test_a_short_password_should_get_an_error() {
        $user = new \App\User\User(
                                    $this->name,
                                    $this->email,
                                    'passwd',
                                    'passwd');

        $this->assertContains("Senha deve ter no mínimo 8 caracteres.", $user->getErrorMessages());
    }

    public function test_a_different_password_and_password_confirmation_should_get_an_error() {
        $user = new \App\User\User(
                                    $this->name,
                                    $this->email,
                                    'password123',
                                    'password000');

        $this->assertContains("Senha e confirmação de senha devem ser iguais.", $user->getErrorMessages());
    }
}