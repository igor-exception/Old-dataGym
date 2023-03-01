<?php

namespace Tests\Unit\App\Validator;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    private $database_mock;

    protected function setUp(): void
    {
        $this->database_mock = $this->createMock(\App\Database\Database::class);
    }

    /**
     * @dataProvider valid_name_dataprovider
     */
    public function test_green_validateName($name, $expected_return): void
    {
        $ret = \App\Validator\GeneralValidator::validateName($name);

        $this->assertEquals($expected_return, $ret);
    }

    /**
     * @dataProvider invalid_name_dataprovider
    */
    public function test_red_validateName($name, $expected_exception): void
    {
        $this->expectException($expected_exception);

        $ret = \App\Validator\GeneralValidator::validateName($name);
    }

    /**
     * @dataProvider valid_email_dataprovider
     */
    public function test_green_validateEmail($email, $expected_return): void
    {
        $ret = \App\Validator\GeneralValidator::validateEmail($email);

        $this->assertEquals($expected_return, $ret);
    }

    /**
     * @dataProvider invalid_email_dataprovider
     */
    public function test_red_validateEmail($email, $expected_exception): void
    {
        $this->expectException($expected_exception);

        $ret = \App\Validator\GeneralValidator::validateEmail($email);
    }


    /**
     * @dataProvider invalid_password_dataprovider
     */
    public function test_red_validatePassword($password, $password_confirmation, $expected_exception): void
    {
        $this->expectException($expected_exception);

        $ret = \App\Validator\GeneralValidator::validatePassword($password, $password_confirmation);
    }


    public function test_red_validateEmailAvailable(): void
    {
        $this->expectException(\App\Exception\EmailAlreadyExists::class);
        
        $ret = \App\Validator\GeneralValidator::validateEmailAvailable('john.doe@gmail.com', $this->database_mock);
        // travei por não saber como fazer mock de método static
    }

    public function valid_name_dataprovider(): array
    {
        return [
            'should_return_filtered_name' => [
                'name' => "<script>alert('ola')</script>", 
                'expected_return' => '&lt;script&gt;alert(&#039;ola&#039;)&lt;/script&gt;'
            ],
            'should_return_trimmed_string' => [
                'name' => "   John Doe   ", 
                'expected_return' => 'John Doe'
            ],
            'should_return_name_when_length_equals_255_chars' => [
                'name' => str_repeat('a', 255),
                'expected_return' => str_repeat('a', 255)
            ],
            'should_return_name_when_length_equals_3_chars' => [
                'name' => 'Joe',
                'expected_return' => 'Joe'
            ],
        ];
    }

    public function invalid_name_dataprovider(): array
    {
        return [
            'should_get_exception_when_give_empty_name' => [
                'name' => '',
                'expected_exception' => \App\Exception\EmptyUserNameException::class
            ],
            'should_get_exception_when_give_name_length_shorter_than_3_chars' => [
                'name' => 'Jo',
                'expected_exception' => \LengthException::class
            ],
            'should_get_exception_when_give_name_length_longer_than_255_chars' => [
                'name' => str_repeat('a', 256),
                'expected_exception' => \LengthException::class
            ],
        ];
    }

    public function valid_email_dataprovider(): array
    {
        return [
            'should_return_email_when_valid_email_is_given' => [
                'name' => 'john.doe@gmail.com', 
                'expected_return' => 'john.doe@gmail.com'
            ],
            'should_return_trimmed_email' => [
                'name' => ' john.doe@gmail.com ', 
                'expected_return' => 'john.doe@gmail.com'
            ],
            'should_return_email_when_lenght_equal_65_chars' => [
                'name' => str_repeat('a', 55) . '@gmail.com',
                'expected_return' => str_repeat('a', 55) . '@gmail.com'
            ],
        ];
    }

    public function invalid_email_dataprovider(): array
    {
        return [
            'should_get_exception_when_give_email_without_domain' => [
                'name' => 'john.doe@',
                'expected_exception' => \App\Exception\InvalidEmailFormatException::class
            ],
            'should_get_exception_when_give_email_without_@_sign' => [
                'name' => 'john.doegmail.com',
                'expected_exception' => \App\Exception\InvalidEmailFormatException::class
            ],
            'should_get_exception_when_give_email_without_localpart' => [
                'name' => '@gmail.com',
                'expected_exception' => \App\Exception\InvalidEmailFormatException::class
            ],
            'should_get_exception_when_give_email_lenght_longer_than_65_chars' => [
                'name' => str_repeat('a', 56) . '@gmail.com',
                'expected_exception' => \LengthException::class
            ],
        ];
    }

    public function invalid_password_dataprovider(): array
    {
        return [
            'should_get_exception_when_give_password_with_blank_spaces' => [
                'password' => '123 456 789',
                'password_confirmation' => '123 456 789',
                'expected_exception' => \App\Exception\InvalidPasswordBlankCharacterException::class
            ],
            'should_get_exception_when_give_password_shorter_than_8_chars' => [
                'password' => '1234567',
                'password_confirmation' => '1234567',
                'expected_exception' => \LengthException::class
            ],
            'should_get_exception_when_give_password_longer_than_255_chars' => [
                'password' => str_repeat('a', 256),
                'password_confirmation' => str_repeat('a', 256),
                'expected_exception' => \LengthException::class
            ],
            'should_get_exception_when_give_different_password_and_password_confirmation' => [
                'password' => '12345678',
                'password_confirmation' => '87654321',
                'expected_exception' => \App\Exception\MismatchPasswordException::class
            ],
        ];
    }
}