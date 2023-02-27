<?php

namespace Tests\Unit\App\Login;

use App\Validator\GeneralValidator;
use App\Login\Login;

class UserTest extends \PHPUnit\Framework\TestCase
{
    private $database_mock;

    protected function setUp(): void
    {
        $this->database_mock = $this->createMock(\App\Database\Database::class);
    }

    /**
     * @dataProvider invalid_login_dataprovider
     */
    public function test_red_login($email, $password, $exception_name): void
    {
        $this->expectException($exception_name);

        $ret = Login::login($email, $password, new \App\Database\Database());
    }

    /**
     * @dataProvider valid_login_dataprovider
     */
    public function test_green_login($email, $password): void
    {
        $this->database_mock->method('search')->willReturn([
            [
                "id"        => 1,
                "name"      => "John Doe",
                "password"  => '$2y$10$pQEdq4MFABZZKDYmxs0cNeFtVCSLKTbkZDtthPwk7i/22u1JUOPIu'
            ]
        ]);

        $ret = Login::login(
            $email,
            $password,
            $this->database_mock
        );

        $this->assertEquals($ret, [
                'name' => 'John Doe',
                'email' => $email,
                'id' => 1
        ]);
    }

    public function invalid_login_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_empty_email' => [
                'email' => '',
                'password' => '123123123',
                'exception_name' => \App\Exception\InvalidEmailOrPassword::class
            ],
            'should_get_an_exception_when_using_empty_password' => [
                'email' => 'john.doe@gmail.com',
                'password' => '',
                'exception_name' => \App\Exception\InvalidEmailOrPassword::class
            ],
            'should_get_an_exception_when_using_wrong_email_or_password' => [
                'email' => 'john.doe@gmail.com',
                'password' => '111111',
                'exception_name' => \App\Exception\InvalidEmailOrPassword::class
            ]
        ];
    }

    public function valid_login_dataprovider(): array
    {
        return [
            'should_get_true_when_using_valid_email_and_password' => [
                'email' => 'john.doe@gmail.com',
                'password' => '123123123'
            ]
        ];
    }
}