<?php

namespace App\Exception;

class MismatchPasswordException extends \Exception
{
    public function __construct($message="Senha e confirmação de senha não podem ser diferentes.")
    {
        parent::__construct($message);
    }
}