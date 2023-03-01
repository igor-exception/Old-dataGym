<?php

namespace App\Action;


class Action {
    private $exercise_id;
    private $weight;
    private $repetitions;
    private $rest;
    private \DateTime $date;
    private $description;
    private \App\Database\Database $database;

    public function __construct($exercise_id, $weight, $repetitions, $rest, \DateTime $date, $description, \App\Database\Database $database)
    {
        $this->setExerciseId($exercise_id);
        $this->setWeight($weight);
        $this->setRepetitions($repetitions);
        $this->setRest($rest);
        $this->setDate($date);
        $this->setDescription($description);
        $this->database = $database;
    }

    private function setExerciseId($id): void
    {

    }

    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    public function setRepetitions($repetitions): void
    {
        $this->repetitions = $repetitions;
    }

    public function setRest($rest): void
    {
        $this->rest = $rest;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }
}