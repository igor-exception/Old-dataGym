<?php

namespace App\Exception;

class DatabaseInsertException extends \Exception
{
    public function __construct($message = "Erro ao inserir!")
    {
        parent::__construct($message);
    }
}