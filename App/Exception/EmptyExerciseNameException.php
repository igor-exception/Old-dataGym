<?php

namespace App\Exception;

class EmptyExerciseNameException extends \Exception
{
    public function __construct($message = "Nome não pode ser vazio.")
    {
        parent::__construct($message);
    }
}