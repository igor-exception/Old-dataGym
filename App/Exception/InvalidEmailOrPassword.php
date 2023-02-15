<?php

namespace App\Exception;

class InvalidEmailOrPassword extends \Exception
{
    public function __construct($message='Email ou senha inválidos.')
    {
        parent::__construct($message);
    }
}