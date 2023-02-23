<?php

namespace App\Exception;

class InvalidUserInfoException extends \Exception
{
    public function __construct($message = 'Informações do usuário inválidas.')
    {
        parent::__construct($message);
    }
}