<?php

namespace App\Exception;

class InvalidEmailFormatException extends \Exception
{
    public function __construct($message = "Email no formato inválido.")
    {
        parent::__construct($message);
    }

}