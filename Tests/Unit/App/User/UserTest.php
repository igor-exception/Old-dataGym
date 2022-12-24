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

        $this->assertNotEmpty($user);
    }

    public function test_an_empty_name_should_get_an_error()
    {
        $this->expectException(\App\Exception\EmptyUserNameException::class);

        $user = new \App\User\User('',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);
    }

    public function test_a_short_name_should_get_an_error()
    {
        $this->expectException(\LengthException::class);
        
        $user = new \App\User\User(
                                    'Jo',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);
    }

    public function test_a_big_name_should_get_an_error()
    {
        $this->expectException(\LengthException::class);
        
        $user = new \App\User\User(
                                    'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                                    $this->email,
                                    $this->password,
                                    $this->password_confirmation);
    }

    public function test_a_invalid_email_should_get_an_error()
    {
        $this->expectException(\App\Exception\InvalidEmailFormatException::class);

        $user = new \App\User\User(
                                    $this->name,
                                    'john.doe.com',
                                    $this->password,
                                    $this->password_confirmation);
    }

    public function test_a_big_email_should_get_an_error()
    {
        $this->expectException(\LengthException::class);

        $user = new \App\User\User(
                                $this->name,
                                '66charssssssssssssssssssssssssssssssssssssssssssssssssss@gmail.com',
                                $this->password,
                                $this->password_confirmation);
    }

    public function test_password_has_blank_character_should_get_an_error()
    {
        $this->expectException(\App\Exception\InvalidPasswordBlankCharacterException::class);

        $user = new \App\User\User(
            $this->name,
            $this->email,
            "asd 123 asd",
            $this->password_confirmation);
    }

    public function test_a_short_password_should_get_an_error()
    {
        $this->expectException(\LengthException::class);

        $user = new \App\User\User(
                                    $this->name,
                                    $this->email,
                                    'passwd',
                                    'passwd');
    }

    public function test_a_different_password_and_password_confirmation_should_get_an_error()
    {
        $this->expectException(\App\Exception\MismatchPasswordException::class);

        $user = new \App\User\User(
                                    $this->name,
                                    $this->email,
                                    'password123',
                                    'password000');
    }
}