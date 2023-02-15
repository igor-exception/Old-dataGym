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
                throw new \App\Exception\DatabaseInsertException;
            }
        } catch(\App\Exception\DatabaseInsertException $e) {
            echo "Erro ao pesquisar dados.". $e->getMessage();
            die();
        } catch (\Throwable $t) {
            echo "Erro entre em contato com o administrador.";
            die();
        }

        return true;
    }

    public function search($table, $params): array
    {
        $this->connect();
        
        try {
            $query = self::mountQuery($table, $params);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch (\Throwable $t) {
            echo "Erro entre em contato com o administrador.";
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

    /** update: acho que foi resolvido!
     * Esta acontecendo erro.
     * Quando é pra buscar apenas um campo, o montador de query fica certo
     * quando tem mais de um, da erro.
     * Talvez transformar o método privado em helper (classe abstrata)
     * Perguntar no grupo
     */
    public static function mountQuery($table, $params): string
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

}
