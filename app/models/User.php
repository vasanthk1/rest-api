<?php
namespace Models;

use Core\Model;
use PDO;

class User extends Model
{
    protected $table = 'users';
    // Define your model properties and methods here

    public function find_by_row_id($id) {
        $db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        );

        $tableName = (new static)->table;
        $statement = $db->prepare("SELECT * FROM $tableName WHERE users_row_Id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
