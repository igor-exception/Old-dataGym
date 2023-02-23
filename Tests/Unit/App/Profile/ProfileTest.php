<?php

namespace Testes\Unit\App\Profile;

class ProfileTest extends \PHPUnit\Framework\TestCase
{
    private $database_mock;

    protected function setUp(): void
    {
        $this->database_mock = $this->createStub(\App\Database\Database::class);
    }

    /**
     * @dataProvider invalid_profile_dataprovider
     */
    public function test_red_cases($id, $name, $password, $password_confirmation, $session_user_id, $exception_name)
    {
        $this->expectException($exception_name);

        $ret = \App\User\User::updateUser($id, $name, $password, $password_confirmation, $this->database_mock, $session_user_id);
    }

    /**
    * @dataProvider valid_profile_dataprovider
    */
    public function test_green_cases($id, $name, $password, $password_confirmation, $session_user_id, $expected_return)
    {

        $this->database_mock->method('search')->willReturn([[
            'id' => '10',
            'name' => 'John Doe',
            'password' => '$2y$10$adZMgNjNpLVgHUZE5FsSM.cq9tRKCfO5J3nrMo/WxrxtISoq.rYda',
            'email' => 'john.doe@gmail.com'
        ]]);

        $this->database_mock->method('update')->willReturn(true);


        $ret = \App\User\User::updateUser($id, $name, $password, $password_confirmation, $this->database_mock, $session_user_id);

        $this->assertEquals($expected_return, $ret);
    }

    public function invalid_profile_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_give_different_user_id_and_session_id' => [
                'id' => '10',
                'name' => 'David Goggins',
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '11',
                'exception_name' => \App\Exception\InvalidUserInfoException::class
            ],
            'should_get_an_exception_when_give_a_empty_user_id' => [
                'id' => '',
                'name' => 'David Goggins',
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '11',
                'exception_name' => \App\Exception\InvalidUserInfoException::class
            ],
            'should_get_an_exception_when_give_an_invented_user_id' => [
                'id' => '30',
                'name' => 'David Goggins',
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '30',
                'exception_name' => \App\Exception\UserNotFoundException::class
            ],
            'should_get_an_exception_when_give_diff_password_and_password_confirmation' => [
                'id' => '30',
                'name' => 'David Goggins',
                'password' => '123a456b',
                'password_confirmation' => 'xxxxxxxx',
                'session_id' => '30',
                'exception_name' => \App\Exception\MismatchPasswordException::class
            ],
            'should_get_an_exception_when_give_a_short_name' => [
                'id' => '30',
                'name' => 'x',
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '30',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_give_a_long_name' => [
                'id' => '30',
                'name' => str_repeat('a', 256),
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '30',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_give_a_long_password' => [
                'id' => '30',
                'name' => 'David Goggins',
                'password' => str_repeat('a', 256),
                'password_confirmation' => str_repeat('a', 256),
                'session_id' => '30',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_give_a_short_password' => [
                'id' => '30',
                'name' => 'David Goggins',
                'password' => '123',
                'password_confirmation' => '123',
                'session_id' => '30',
                'exception_name' => \LengthException::class
            ],
        ];
    }

    public function valid_profile_dataprovider(): array
    {
        return [
            'should_return_true_when_give_valid_information' => [
                'id' => '10',
                'name' => 'David Goggins',
                'password' => '123a456b',
                'password_confirmation' => '123a456b',
                'session_id' => '10',
                'expected_return' => true
            ],
            'should_return_false_when_give_unchanged_info_to_update' => [
                'id' => '10',
                'name' => 'John Doe',
                'password' => '123123123',
                'password_confirmation' => '123123123',
                'session_id' => '10',
                'expected_return' => false
            ]
        ];
    }
}