<?php

namespace App\Exception;

class EmailAlreadyExists extends \Exception
{
    public function __construct($message = 'Já possui uma conta registrada com este email.')
    {
        parent::__construct($message);
    }
}