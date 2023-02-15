<?php

namespace App\Exception;

class InvalidPasswordException extends \Exception
{
    public function __construct($message='Erro ao persistir senha.')
    {
        parent::__construct($message);
    }
}