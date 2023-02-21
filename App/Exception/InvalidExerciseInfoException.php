<?php

namespace App\Exception;

class InvalidExerciseInfoException extends \Exception
{
    public function __construct($message = 'Informações do Exercício inválidas.')
    {
        parent::__construct($message);
    }
}