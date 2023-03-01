<?php

namespace App\Exercise;

use \App\Validator\GeneralValidator;

class Exercise {
    private $name;
    private $description;
    private $id;
    private $user_id;
    private \App\Database\Database $database;

    public function __construct($name, $description, $user_id, \App\Database\Database $database)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setUserId($user_id);
        $this->database = $database;
        
        $this->createExercise();
    }

    private function setName($name): void
    {
        $this->name = GeneralValidator::validateExerciseName($name);
    }

    private function setDescription($description): void
    {
        $this->description = GeneralValidator::validateExerciseDescription($description);
    }

    private function setUserId($user_id): void
    {
        $uid = GeneralValidator::validateUserId($user_id);

        $this->user_id = $uid;
    }

    private function createExercise(): void
    {
        $exercise_id = $this->database->insert('exercises', $this->getExerciseArray());
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
        $id = GeneralValidator::validateExerciseId($id);

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
        $id = GeneralValidator::validateExerciseId($id);
        $name = GeneralValidator::validateExerciseName($name);
        $description = GeneralValidator::validateExerciseDescription($description);

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
        $id = GeneralValidator::validateExerciseId($id);
        GeneralValidator::validateExerciseIdExists($id, $database);

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
}