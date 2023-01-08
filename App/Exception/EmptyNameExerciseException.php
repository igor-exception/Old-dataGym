<?php

namespace App\Exception;

class EmptyNameExerciseException extends \Exception
{
    public function __construct($message = 'Nome do exercício não pode ser vazio.')
    {
        parent::__construct($message);
    }
}