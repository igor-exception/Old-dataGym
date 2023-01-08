<?php

namespace Tests\Unit\App\User;

class UserTest extends \PHPUnit\Framework\TestCase
{
    private $name = 'John';
    private $email = 'john.doe@gmail.com';
    private $password = '12345678';
    private $password_confirmation = '12345678';

    /**
     * @dataProvider names_dataprovider
     */
    public function test_name($name, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $name,
            $this->email,
            $this->password,
            $this->password_confirmation
        );
    }

    /**
     * @dataProvider emails_dataprovider
     */
    public function test_email($email, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $this->name,
            $email,
            $this->password,
            $this->password_confirmation
        );
    }

    /**
     * @dataProvider passwords_dataprovider
     *
     */
    public function test_password($password, $password_confirmation, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $this->name,
            $this->email,
            $password,
            $password_confirmation
        );
    }

    public function names_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_empty_name' => ['', \App\Exception\EmptyUserNameException::class],
            'should_get_an_exception_when_using_name_shorter_than_3_chars' => ['Jo', \LengthException::class],
            'should_get_an_exception_when_using_name_bigger_than_256_chars' => [str_repeat('a', 257), \LengthException::class]
        ];
    }

    public function emails_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_email_without_@_symbol' => ['john.doe.com', \App\Exception\InvalidEmailFormatException::class],
            'should_get_an_exception_when_using_email_bigger_than_65_chars' => ['66charssssssssssssssssssssssssssssssssssssssssssssssssss@gmail.com', \LengthException::class]
        ];
    }

    public function passwords_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_blank_spaces_in_password' => ['asd 123 asd', 'asd 123 asd', \App\Exception\InvalidPasswordBlankCharacterException::class],
            'should_get_an_exception_when_using_password_shorter_than_8_chars' => ['passwd', 'passwd', \LengthException::class],
            'should_get_an_exception_when_using_mismatching_password_and_password_confirmation' => ['password123', 'password000', \App\Exception\MismatchPasswordException::class]
        ];
    }
}