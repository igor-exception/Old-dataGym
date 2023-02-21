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

    public function insert($table, $params = null): string
    {
        $this->connect();
        try {
            $fields = $this->getKeysFromArray($params);
            $values = $this->getValuesFromArray($params);
            $query = "INSERT INTO {$table}({$fields}) VALUES({$values})";

            $stmt = $this->db->prepare($query);
            if(!$stmt->execute()) {
                throw new \App\Exception\DatabaseInsertException;
            }
        } catch(\App\Exception\DatabaseInsertException $e) {
            echo "Erro ao cadastrar dados.". $e->getMessage();
            die();
        } catch (\Throwable $t) {
            echo "Erro entre em contato com o administrador.";
            die();
        }

        $insertedId = (int) $this->db->lastInsertId();

        return $insertedId;
    }

    public function search($table, $params): array
    {
        $this->connect();
        
        try {
            $query = self::mountSelectQuery($table, $params);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch (\Throwable $t) {
            echo "Erro. Entre em contato com o administrador.";
            die();
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getKeysFromArray($array): string
    {
        return implode(', ', array_keys($array));
    }

    public static function getValuesFromArray($array): string
    {
        return "'" . implode("', '", array_values($array))."'";
    }

    public static function getSelectFieldsFromArray($array): string
    {
        return implode(', ', array_values($array));
    }

    public static function mountSelectQuery($table, $params): string
    {
        $query = '';

        if(empty($table)) {
            throw new \InvalidArgumentException('Nome da tabela não pode ser vazio');
        }

        $field = Database::getSelectFieldsFromArray($params['fields']);
        if(count($params['where']) == 1) {
            $where_key = Database::getKeysFromArray($params['where']);
            $where_value = Database::getValuesFromArray($params['where']);
            $query = "SELECT {$field} FROM {$table} WHERE {$where_key}={$where_value}";
        } elseif(count($params['where']) >= 2) {
            $query = "SELECT {$field} FROM {$table} WHERE ";
            $last_key = array_key_last($params['where']);
            foreach($params['where'] as $key => $value) {
                $query.= $key. "='{$value}'";
                if($key != $last_key) {
                    $query.= " AND ";
                }
            }
        } else {
            $query = "SELECT {$field} FROM {$table}";
        }

        return $query;
    }

    public function update($table, $params)
    {
        $this->connect();

        try {
            $query = self::mountUpdateQuery($table, $params);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
        } catch (\Throwable $t) {
            echo "Erro. Entre em contato com o administrador.";
            die();
        }

        if($count <= 0) {
            return false;
        }

        return true;
    }

    public static function mountUpdateQuery($table, $params): string
    {
        $fields = '';

        if(empty($table)) {
            throw new \InvalidArgumentException('Nome da tabela não pode ser vazio');
        }

        if(empty($params['where'])) {
            throw new \InvalidArgumentException('Argumentos inválidos ao tentar atualizar');
        }

        if(count($params['update']) >= 1) {
            $where = '';
            $where_key = Database::getKeysFromArray($params['where']);
            $where_value = Database::getValuesFromArray($params['where']);
            $where .= "{$where_key} = {$where_value}";
            $last_key = array_key_last($params['update']);
            foreach($params['update'] as $key => $value) {
                $fields .= $key. "='{$value}'";
                if($key != $last_key) {
                    $fields.= ", ";
                }
            }
            $query = "UPDATE {$table} SET {$fields} WHERE {$where}";
        }

        return $query;
    }

    public function delete($table, $params)
    {
        $this->connect();

        try {
            $query = self::mountDeleteQuery($table, $params);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
        } catch (\Throwable $t) {
            echo "Erro. Entre em contato com o administrador.";
            die();
        }

        if($count <= 0) {
            return false;
        }

        return true;
    }

    public static function mountDeleteQuery($table, $params): string
    {
        if(empty($table)) {
            throw new \InvalidArgumentException('Nome da tabela não pode ser vazio');
        }

        if(empty($params['where'])) {
            throw new \InvalidArgumentException('Argumentos inválidos ao tentar atualizar');
        }

        if(count($params['where']) >= 1) {
            $where = '';
            $where_key = Database::getKeysFromArray($params['where']);
            $where_value = Database::getValuesFromArray($params['where']);
            $where .= "{$where_key} = {$where_value}";

            $query = "DELETE FROM {$table} WHERE {$where}";
        }

        return $query;
    }

}
