<?php

namespace Tests\Exercise;

class ExerciseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider invalid_names_dataprovider
     */
    public function test_red_cases($name, $exception_name)
    {
        $this->expectException($exception_name);
        $exercise = new \App\Exercise\Exercise($name);
    }

    /**
     * @dataProvider valid_names_dataprovider
     */
    public function test_green_cases($name)
    {
        $exercise = new \App\Exercise\Exercise($name);

        $this->assertInstanceOf(\App\Exercise\Exercise::class, $exercise);
    }

    public function invalid_names_dataprovider()
    {
        return [
            'should_get_an_exception_when_name_less_or_equal_2_chars' => ['name' => 'ab', 'exception_name' => \LengthException::class],
            'should_get_an_exception_when_name_longer_than_200_chars' => ['name' => str_repeat('a', 201), 'exception_name' => \LengthException::class],
            'should_get_an_exception_when_name_is_empty' => ['name' => '', 'exception_name' => \App\Exception\EmptyNameExerciseException::class]
        ];
    }

    public function valid_names_dataprovider()
    {
        return [
            'should_not_get_an_exception_when_name_equal_3_chars' => ['name' => 'abs'],
            'should_not_get_an_exception_when_name_equal_200_chars' => ['name' => str_repeat('a', 200)],
            'should_not_get_an_exception_when_name_less_than_200' => ['name' => 'Pulley costas', 200]
        ];
    }
}