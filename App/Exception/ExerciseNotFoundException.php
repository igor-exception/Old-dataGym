<?php

namespace App\Exception;

class ExerciseNotFoundException extends \Exception
{
    public function __construct($message = "Exercício não encontrado")
    {
        parent::__construct($message);
    }
}