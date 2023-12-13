<?php
namespace Core;

use PDO;

class Model
{
    protected $db;
    protected $table;

    public function __construct($data = [])
    {
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function all()
    {
        $db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );

        $tableName = (new static)->table;
        $statement = $db->query("SELECT * FROM $tableName");
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function find($id)
    {
        $db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );

        $tableName = (new static)->table;
        $statement = $db->prepare("SELECT * FROM $tableName WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    public function save()
    {
        $tableName = $this->table;
        $attributes = get_object_vars($this);

        unset($attributes['db']);
        unset($attributes['table']);

        $columns = implode(', ', array_keys($attributes));
        $values = implode(', ', array_map(function ($value) {
            return ":$value";
        }, array_keys($attributes)));

        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

        $statement = $this->db->prepare($query);

        foreach ($attributes as $key => &$value) {
            $statement->bindParam(":$key", $value);
        }

        $statement->execute();
    }

    public function update($data, $id)
    {
        $tableName = $this->table;
        $updateString = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $query = "UPDATE $tableName SET $updateString WHERE id = :id";

        $statement = $this->db->prepare($query);

        foreach ($data as $key => &$value) {
            $statement->bindParam(":$key", $value);
        }

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();
    }

    public function destroy()
    {
        $tableName = $this->table;
        $query = "DELETE FROM $tableName WHERE id = :id";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $this->id, PDO::PARAM_INT);

        $statement->execute();
    }
}
