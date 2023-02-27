<?php

namespace Tests\Unit\App\User;

use App\Validator\GeneralValidator;

class UserTest extends \PHPUnit\Framework\TestCase
{
    private $name = 'John';
    private $email = 'john.doe@gmail.com';
    private $password = '12345678';
    private $password_confirmation = '12345678';
    private $database_mock;

    protected function setUp(): void
    {
        $this->database_mock = $this->createMock(\App\Database\Database::class);
    }

    /**
     * @dataProvider invalid_names_dataprovider
     */
    public function test_red_name($name, $exception_name): void
    {
        $this->expectException($exception_name);
        
        \App\Validator\GeneralValidator::validateName($name);
    }

    /**
     * @dataProvider valid_names_dataprovider
     */
    public function test_green_name($name, $expected_name)
    {
        $validated_name = \App\Validator\GeneralValidator::validateName($name);

        $this->assertEquals($expected_name, $validated_name);
    }

    /**
     * @dataProvider invalid_emails_dataprovider
     */
    public function test_red_email($email, $exception_name): void
    {
        $this->expectException($exception_name);

        \App\Validator\GeneralValidator::validateEmail($email);
    }

    /**
     * @dataProvider valid_emails_dataprovider
     */
    public function test_green_email($email, $expected_email): void
    {
        $validated_email = \App\Validator\GeneralValidator::validateEmail($email);

        $this->assertEquals($expected_email, $validated_email);
    }

    /**
     * @dataProvider invalid_passwords_dataprovider
     *
     */
    public function test_red_password($password, $password_confirmation, $exception_name): void
    {
        $this->expectException($exception_name);
        
        \App\Validator\GeneralValidator::validatePassword($password, $password_confirmation);
    }

    /**
     * @dataProvider valid_passwords_dataprovider
     *
     */
    public function test_green_password($password, $password_confirmation, $expected_password): void
    {
        \App\Validator\GeneralValidator::validatePassword($password, $password_confirmation);

        $this->assertEquals($password, $expected_password);
    }

    public function invalid_names_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_empty_name' => [
                'name' => '', 
                'exception_name' => \App\Exception\EmptyUserNameException::class
            ],
            'should_get_an_exception_when_using_name_shorter_than_3_chars' => [
                'name' => 'Jo',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_using_name_bigger_than_255_chars' => [
                'name' => str_repeat('a', 256),
                'exception_name' => \LengthException::class
            ]
        ];
    }

    public function valid_names_dataprovider(): array
    {
        return [
            'should_be_valid_when_name_not_empty' => [
                'name' => 'John Doe',
                'expected_name' => 'John Doe'
            ],
            'should_be_valid_when_name_equals_3_chars' => [
                'name' => 'Joe',
                'expected_name' => 'Joe'
            ],
            'should_be_valid_when_name_equals_255_chars' => [
                'name' => str_repeat('a', 255),
                'expected_name' => str_repeat('a', 255)
            ],
            'should_be_valid_when_name_trimmed' => [
                'name' => '   John Doe   ',
                'expected_name' => 'John Doe'
            ]
        ];
    }

    public function invalid_emails_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_email_without_@_symbol' => [
               'email' => 'john.doe.com',
               'expected_exception' => \App\Exception\InvalidEmailFormatException::class
            ],
            'should_get_an_exception_when_using_email_bigger_than_65_chars' => [
                'email' => '66charssssssssssssssssssssssssssssssssssssssssssssssssss@gmail.com',
                'expected_exception' => \LengthException::class
            ]
        ];
    }

    public function valid_emails_dataprovider(): array
    {
        return [
            'should_be_valid_when_email_is_valid' => [
                'email' => 'john.doe@gmail.com',
                'expected_email' => 'john.doe@gmail.com'
            ],
            'should_be_valid_when_valid_email_equals_65_chars' => [
                'email' => 'john.doeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee@gmail.com',
                'expected_email' => 'john.doeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee@gmail.com'
            ],
        ];
    }

    public function invalid_passwords_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_blank_spaces_in_password' => [
                'password' => 'asd 123 asd',
                'password_confirmation' => 'asd 123 asd',
                'exception_name' => \App\Exception\InvalidPasswordBlankCharacterException::class
            ],
            'should_get_an_exception_when_using_password_shorter_than_8_chars' => [
                'password' => 'passwd',
                'password_confirmation' => 'passwd',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_using_password_bigger_than_255_chars' => [
                'password' => str_repeat('a', 256),
                'password_confirmation' => str_repeat('a',256),
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_using_mismatching_password_and_password_confirmation' => [
                'password' => 'password123',
                'password_confirmation' => 'password000',
                'exception_name' => \App\Exception\MismatchPasswordException::class
            ]
        ];
    }

    public function valid_passwords_dataprovider(): array
    {
        return [
            'should_get_an_instance_of_object_when_valid_password_and_password_confirmation' => [
                'password' => '12345678',
                'password_confirmation' =>'12345678',
                'expected_password' => '12345678'
            ],
            'should_get_an_instance_of_object_when_password_equals_255_chars' => [
                'password' => str_repeat('a', 255),
                'password_confirmation' => str_repeat('a',255),
                'expected_password' => str_repeat('a', 255)
            ],
        ];
    }
}