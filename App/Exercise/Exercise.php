<?php

namespace App\Exercise;

class Exercise {
    private $name;

    public function __construct($name)
    {
        $this->setName($name);
    }

    private function setName($name): void
    {
        $name = htmlspecialchars($name);
        $name = trim($name);

        if(empty($name)) {
            throw new \App\Exception\EmptyNameExerciseException();
        }

        if(strlen($name) <= 2) {
            throw new \LengthException('Nome muito curto. Precisa ser maior que 2 caracteres.');
        }

        if(strlen($name) > 200) {
            throw new \LengthException('Nome muito Longo. Precisa ser menor que 200 caracteres.');
        }
        
        $this->name = $name;
    }
}