<?php

namespace Tests\Exercise;

class ExerciseTest extends \PHPUnit\Framework\TestCase
{
    private $database_mock;

    protected function setUp(): void
    {
        $this->database_mock = $this->createStub(\App\Database\Database::class);
    }

    /**
     * @dataProvider invalid_exercise_name_dataprovider
     */
    public function test_red_name($name, $description, $user_id, $exception_name)
    {
        $this->expectException($exception_name);

        $exercise = new \App\Exercise\Exercise($name, $description, $user_id, $this->database_mock);
    }

    /**
     * @dataProvider valid_exercise_name_dataprovider
     */
    public function test_green_name($name, $description, $user_id): void
    {
        $this->database_mock->method('insert');
        $exercise = new \App\Exercise\Exercise($name, $description, $user_id, $this->database_mock);

        $this->assertInstanceOf(\App\Exercise\Exercise::class, $exercise);
    }

    /**
     * @dataProvider invalid_exercise_description_dataprovider
     */
    public function test_red_description($name, $description, $user_id, $exception_name)
    {
        $this->expectException($exception_name);

        $exercise = new \App\Exercise\Exercise($name, $description, $user_id, $this->database_mock);
    }

    /**
     * @dataProvider invalid_exercise_user_id_dataprovider
     */
    public function test_red_user_id($name, $description, $user_id, $exception_name)
    {
        $this->expectException($exception_name);

        $exercise = new \App\Exercise\Exercise($name, $description, $user_id, $this->database_mock);
    }

    /**
     * @dataProvider valid_getExercise_dataprovider
     */
    public function test_green_getExercise($id): void
    {
        $this->database_mock->method('search')->willReturn([
            [
                'id' => 10,
                'name' => 'Remada baixa',
                'description' => 'Usando corda'
            ]
        ]);

        $exercise_info = \App\Exercise\Exercise::getExercise($id, $this->database_mock);

        $this->assertEquals($exercise_info, [
            'id' => 10,
            'name' => 'Remada baixa',
            'description' => 'Usando corda'
        ]);
    }

    /**
     * @dataProvider invalid_getExercise_dataprovider
     */
    public function test_red_getExercise($id, $exception_name): void
    {
        $this->expectException($exception_name);

        $this->database_mock->method('search')->willReturn([]);

        $exercise = \App\Exercise\Exercise::getExercise($id, $this->database_mock);
    }

    /**
     * @dataProvider invalid_updateExercise_dataprovider
     */
    public function test_red_updateExercise($id, $name, $description, $exception_name): void
    {
        $this->expectException($exception_name);

        $this->database_mock->method('search')->willReturn([]);
        $this->database_mock->method('update')->willReturn(true);

        $exercise = \App\Exercise\Exercise::updateExercise($id, $name, $description, $this->database_mock);
    }


    /**
     * @dataProvider valid_updateExercise_dataprovider
     */
    public function test_green_updateExercise($id, $name, $description, $expected_return): void
    {
        $this->database_mock->method('search')->willReturn([[
                                                                'id' => '10',
                                                                'name' => 'remada',
                                                                'description' => ''
                                                            ]]);
        $this->database_mock->method('update')->willReturn(true);

        $ret = \App\Exercise\Exercise::updateExercise($id, $name, $description, $this->database_mock);
        $this->assertEquals($expected_return, $ret);
    }

    /**
     * @dataProvider invalid_deleteExercise_dataprovider
     */
    public function test_red_deleteExercise($id, $exception_name):void
    {
        $this->expectException($exception_name);

        $this->database_mock->method('delete')->willReturn(false);

        $exercise = \App\Exercise\Exercise::deleteExercise($id, $this->database_mock);
    }

        /**
     * @dataProvider valid_deleteExercise_dataprovider
     */
    public function test_green_deleteExercise($id, $expected_return):void
    {
        $this->database_mock->method('search')->willReturn([[
            'id' => '10',
            'name' => 'remada',
            'description' => ''
        ]]);
        $this->database_mock->method('delete')->willReturn(true);

        $ret = \App\Exercise\Exercise::deleteExercise($id, $this->database_mock);

        $this->assertEquals($expected_return, $ret);
    }

    public function invalid_exercise_name_dataprovider()
    {
        return [
            'should_get_an_exception_when_name_less_or_equal_2_chars' => [
                'name' => 'ab', 
                'description' => '',
                'user_id' => '10',
                'exception_name' => \LengthException::class
            ],
            
            'should_get_an_exception_when_name_longer_than_200_chars' => [
                'name' => str_repeat('a', 201), 
                'description' => '',
                'user_id' => '10',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_name_is_empty' => [
                'name' => '', 
                'description' => '',
                'user_id' => '10',
                'exception_name' => \App\Exception\EmptyExerciseNameException::class
            ]
        ];
    }

    public function valid_exercise_name_dataprovider()
    {
        return [
            'should_not_get_an_exception_when_name_equal_3_chars' => [
                'name' => 'abs',
                'description' => '',
                'user_id' => '10'
            ],
            'should_not_get_an_exception_when_name_equal_200_chars' => [
                'name' => str_repeat('a', 200),
                'description' => '',
                'user_id' => '10'
            ],
            'should_not_get_an_exception_when_name_less_than_200' => [
                'name' => 'Pulley costas',
                'description' => '',
                'user_id' => '10'
            ]
        ];
    }

    public function invalid_exercise_description_dataprovider()
    {
        return [
            'should_get_an_exception_when_description_longer_than_65000_chars' => [
                'name' => 'supino',
                'description' => str_repeat('a', 65001),
                'user_id' => '10',
                'exception_name' => \LengthException::class
            ]
        ];
    }


    public function invalid_exercise_user_id_dataprovider()
    {
        return [
            'should_get_an_exception_when_user_id_is_empty' => [
                'name' => 'supino',
                'description' => '',
                'user_id' => '',
                'exception_name' => \App\Exception\InvalidUserInfoException::class
            ]
        ];
    }


    public function valid_getExercise_dataprovider()
    {
        return [
            'should_not_get_an_exception_when_give_valid_exercise_id' => ['id' => '10'],
        ];
    }

    public function invalid_getExercise_dataprovider()
    {
        return [
            'should_get_an_exception_when_give_invalid_exercise_id' => [
                'id' => '999', 
                'exception_name' => \App\Exception\ExerciseNotFoundException::class
            ],
            'should_get_an_exception_when_give_empty_exercise_id' => [
                'id' => '',
                'exception_name' => \App\Exception\InvalidExerciseInfoException::class
            ]
        ];
    }

    public function invalid_updateExercise_dataprovider()
    {
        return [
            'should_get_an_exception_when_give_an_empty_exercise_id' => [
                'id' => '',
                'name' => 'supino',
                'description' => '',
                'exception_name' => \App\Exception\InvalidExerciseInfoException::class
            ],
            'should_get_an_exception_when_give_an_empty_exercise_name' => [
                'id' => '1',
                'name' => '',
                'description' => '',
                'exception_name' => \App\Exception\EmptyExerciseNameException::class
            ],
            'should_get_an_exception_when_give_an_invented_exercise_id' => [
                'id' => '555',
                'name' => 'supino',
                'description' => '',
                'exception_name' => \App\Exception\ExerciseNotFoundException::class
            ],
            'should_get_an_exception_when_name_longer_than_200_chars' => [
                'id' => '1',
                'name' => str_repeat('a', 201),
                'description' => '',
                'exception_name' => \LengthException::class
            ],
            'should_get_an_exception_when_description_longer_than_65000_chars' => [
                'id' => '1', 
                'name' => 'Supino',
                'description' => str_repeat('a', 65001),
                'exception_name' => \LengthException::class
            ]

        ];
    }

    public function valid_updateExercise_dataprovider()
    {
        return [
            'should_return_true_when_give_different_exercise_name_and_description' => [
                'id' => '10',
                'name' => 'remada alta',
                'description' => 'cabo',
                'expected_return' => true
            ],
            'should_return_true_when_give_only_different_exercise_name' => [
                'id' => '10',
                'name' => 'remada baixa',
                'description' => '',
                'expected_return' => true
            ],
            'should_return_true_when_give_only_different_exercise_description' => [
                'id' => '10',
                'name' => 'remada',
                'description' => 'Até a falha',
                'expected_return' => true
            ],
            'should_return_false_when_give_unchange_info' => [
                'id' => '10', 
                'name' => 'remada', 
                'description' => '',
                'expected_return' => false
            ],
            'should_return_true_when_give_name_less_or_equal_200_chars' => [
                'id' => '1',
                'name' => str_repeat('a', 200),
                'description' => '',
                'expected_return' => true],
            'should_return_true_when_give_description_less_or_equal_65000_chars' => [
                'id' => '1',
                'name' => 'Supino',
                'description' => str_repeat('a', 65000), 
                'expected_return' => true
            ],
            
            'should_return_true_when_give_especific_description' => [
                'id' => '10',
                'name' => 'Supino Reto',
                'description' => 'Músculos solicitados no supino reto
                    De modo geral, temos 4 músculos solicitados de forma prioritária no supino reto:
                    
                    Peitoral maior;
                    Peitoral menor;
                    Tríceps braquial;
                    Deltoide.
                    Destes, o músculo com menos solicitação, sendo mais um estabilizador, é o peitoral menor. Os outros 3, são os mais solicitados.
                    
                    O movimento do supino reto é basicamente, uma flexão horizontal do ombro (alguns estudiosos chamam este movimento de adução horizontal), com uma extensão de cotovelo.
                    
                    No caso do movimento de flexão horizontal do ombro, o movimento com mais amplitude, temos como base o peitoral maior e o deltoide (principalmente a porção anterior). Já na extensão do cotovelo, temos o trabalho do tríceps braquial.
                    
                    Por isso, o principal músculo solicitado no supino reto é o peitoral maior. Isso faz com que o supino reto seja uma das bases do treino de peito.
                    
                    Os outros músculos são sinergistas e se a execução for adequada, não teremos um trabalho tão intenso nestes músculos, como nos movimentos mais “isolados”',
                'expected_return' => true]
        ];
    }

    public function invalid_deleteExercise_dataprovider()
    {
        return [
            'should_get_an_exception_when_give_an_empty_exercise_id' => [
                'id' => '',
                'exception_name' => \App\Exception\InvalidExerciseInfoException::class
            ],
            'should_get_an_exception_when_give_an_invented_exercise_id' => [
                'id' => '999',
                'exception_name' => \App\Exception\ExerciseNotFoundException::class
            ],
        ];
    }

    
    public function valid_deleteExercise_dataprovider()
    {
        return [
            'should_return_true_when_give_a_valid_exercise_id' => [
                'id' => '10',
                'expected_return' => true
            ],
        ];
    }
}