<?php

namespace App\Infra\Database;

use \PDO;
use \PDOException;

class Connector
{
    private $user;
    private $pass;
    private $dbname;
    private $host;
    public PDO $pdo;

    public function __construct($user, $pass, $dbname, $host)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->host = $host;

        $this->connect();
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname,$this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            return $statement;

        } catch (PDOExeption $e) {
            die($e->getMessage());
        }
    }

    public function create($values)
    {
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), "?");

        $query = "INSERT INTO login " . "(" . implode(",", $fields) . ") VALUES (" . implode(",", $binds) . ")";

        $this->execute($query, array_values($values));

        return $this->pdo->lastInsertId();
    }

    public function find($id)
    {
        $query = "SELECT * FROM login  WHERE id= ?";
        return $this->execute($query, [$id]);
    }

    public function edit($id, $values)
    {
        $values = array_filter($values, function ($item) { //Remove os valores nulos do array $values.
            return $item !== null;
        });

        $fields = array_keys($values); //Obtém as chaves do array associativo $values (nomes dos campos a serem atualizados).

        $query = "UPDATE login SET " . implode("=?, ", $fields) . "=? WHERE id = ?"; // Monta a consulta SQL de atualização com base nos nomes dos campos.

        $values[] = $id; //Adiciona o ID como último valor no array $values.

        $this->execute($query, array_values($values)); // Executa a consulta SQL, substituindo os placeholders pelos valores correspondentes.

        return true;
    }

    public function delete($id)
    {
        $query = "DELETE FROM login WHERE `id` = ?";
        $this->execute($query, [$id]);
        return true;
    }

    public function list()
    {
$query = "SELECT * FROM login";
return $this->execute($query);
    }

}
