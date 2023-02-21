<?php

namespace App\Exercise;

class Exercise {
    private $name;
    private $description;
    private $id;
    private \App\Database\Database $database;

    public function __construct($name, $description, \App\Database\Database $database)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->database = $database;
        
        $this->createExercise();
    }

    private function setName($name): void
    {
        $this->name = self::validateName($name);
    }

    private function setDescription($description): void
    {
        $this->description = self::validateDescription($description);
    }

    private function createExercise(): void
    {
        $exercise_id = $this->database->insert('exercises', $this->getExerciseArray());
        $this->id = $exercise_id;
    }

    private function getExerciseArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public static function getExercises(\App\Database\Database $database): array
    {
        return $database->search('exercises', ['fields' => ['id', 'name', 'description'], 'where' => []]);
    }

    public static function getExercise($id, \App\Database\Database $database): array
    {
        $id = self::validateId($id);

        $ret = $database->search('exercises', ['fields' => ['id', 'name', 'description'], 'where' => ['id' => $id]]);

        if(count($ret) < 1) {
            throw new \App\Exception\ExerciseNotFoundException();
        }

        return [
            'id' => $ret[0]['id'],
            'name' => $ret[0]['name'],
            'description' => $ret[0]['description']
        ];
    }

    public static function updateExercise($id, $name, $description, \App\Database\Database $database): bool
    {
        $id = self::validateId($id);
        $name = self::validateName($name);
        $description = self::validateDescription($description);

        $ret = $database->search('exercises', ['fields' => ['id', 'name', 'description'], 'where' => ['id' => $id]]);

        if(count($ret) < 1) {
            throw new \App\Exception\ExerciseNotFoundException();
        }

        $fields = [];
        // ira atualizar apenas o que tiver de diferente
        // ver o que tem de diferente do form comparando com dados do banco
        if($ret[0]['name'] != $name) {
            $fields['name'] = $name;
        }

        if($ret[0]['description'] != $description) {
            $fields['description'] = $description;
        }

        // caso nao tenha nada de diferente, nao atualiza. Apenas retorna false
        if(empty($fields)) {
            return false;
        }

        // dar update só nas mudanças
        $ret = $database->update('exercises', ['update' => $fields, 'where' => ['id' => $id]]);

        return $ret;
    }

    public static function  deleteExercise($id, \App\Database\Database $database): bool
    {
        $id = self::validateId($id);
        self::validateIdExists($id, $database);

        $ret = $database->delete('exercises', ['where' => ['id' => $id]]);
        if(!$ret) {
            return false;
        }

        return true;
    }

    public function getId(): ?string
    {
        if(!isset($this->id)) {
            return null;
        }

        return $this->id;
    }

    public static function validateId($id): string
    {
        $id = htmlspecialchars($id);
        $id = trim($id);

        if(empty($id)) {
            throw new \App\Exception\InvalidExerciseInfoException();
        }

        return $id;
    }

    public static function validateIdExists($id, \App\Database\Database $database): void
    {
        self::getExercise($id, $database);
    }

    public static function validateName($name): string
    {
        $name = htmlspecialchars($name);
        $name = trim($name);

        if(empty($name)) {
            throw new \App\Exception\EmptyExerciseNameException();
        }

        if(strlen($name) <= 2) {
            throw new \LengthException('Nome muito curto. Precisa ser maior que 2 caracteres.');
        }

        if(strlen($name) > 200) {
            throw new \LengthException('Nome muito Longo. Precisa ser menor que 200 caracteres.');
        }

        return $name;
    }

    public static function validateDescription($description): string
    {
        $description = htmlspecialchars($description);
        $description = trim($description);

        if(strlen($description) > 65000) {
            throw new \LengthException('Descrição muito Longa. Precisa ser menor que 65.000 caracteres.');
        }

        return $description;
    }
}