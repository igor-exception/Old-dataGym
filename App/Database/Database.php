<?php
namespace App\Database;

use PDO;

class Database
{
    private const HOST = 'db';
    private const DBNAME = 'datagym';
    private const USER = 'root';
    private const PASSWD = 'root';

    private PDO $db;

    private function connect(): PDO
    {
        try {
            if(!isset($this->db)){
                $this->db = new PDO('mysql:host='.static::HOST.';dbname='.static::DBNAME, static::USER, static::PASSWD);
            }
        } catch (\PDOException $pdo) {
            echo "ERRO: ". $pdo->getMessage();
            die();
        }

        return $this->db;
    }

    public function insert($table, $params = null): bool
    {
        $this->connect();
        try {
            $fields = $this->getKeysFromArray($params);
            $values = $this->getValuesFromArray($params);
            $query = "INSERT INTO {$table}({$fields}) VALUES({$values})";

            $stmt = $this->db->prepare($query);
            if(!$stmt->execute()) {
                Throw new \App\Exception\DatabaseInsertException;
            }
        } catch(\App\Exception\DatabaseInsertException $e) {
            echo "Erro ao inserir usuário". $e->getMessage();
            die();
        } catch (\Throwable $t) {
            echo "Erro procure um administrador.";
            die();
        }

        return true;
    }

    private function getKeysFromArray($array): string
    {
        return implode(', ', array_keys($array));
    }

    private function getValuesFromArray($array): string
    {
        return "'" . implode("', '", array_values($array))."'";
    }

}