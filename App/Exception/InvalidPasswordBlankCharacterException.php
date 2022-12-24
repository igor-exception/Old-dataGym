<?php

namespace App\Exception;

class InvalidPasswordBlankCharacterException extends \Exception
{
    public function __construct($message="Senha não pode ter espaço como caractere.")
    {
        parent::__construct($message);
    }
}