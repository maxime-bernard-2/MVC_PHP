<?php

declare (strict_types = 1);

namespace app\core;

/**
 * Undocumented class
 */
abstract class DBModel extends Model
{
    abstract public static function tableName(): string;

    /**
     * Undocumented function
     *
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(static fn($attr) => ":$attr", $attributes);
        $statement = Application::$app->db->pdo->prepare("
            INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES (" . implode(',', $params) . ")
        ");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    /**
     * Undocumented function
     *
     * @param string $sql
     * @return \PDOStatement
     */
    public static function prepare(string $sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    /**
     * Undocumented function
     *
     * @param array $select
     * @param array $where
     * @return Model
     */
    public static function selectWhere(array $where, array $select = [])
    {
        $tableName = static::tableName();
        $where_statements = array_keys($where);

        $select_sql = (empty($select)) ? '*' : implode(",", $select);
        $where_sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $where_statements));

        $statement = self::prepare("SELECT $select_sql FROM $tableName WHERE $where_sql");

        foreach ($where as $key => $item) {
            $statement->bindValue("$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    /**
     * Undocumented function
     *
     * @param array $where
     * @param array $select
     * @return void
     */
    public static function updateWhere(array $where, array $select = [])
    {
        $tableName = static::tableName();
        $where_statements = array_keys($where);

        $select_sql = implode(",", array_map(fn($attr) => "$attr = :$attr", $where_statements));
        $where_sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $where_statements));

        $statement = self::prepare("UPDATE $tableName SET $select_sql WHERE $where_sql");

        foreach ($where as $key => $item) {
            $statement->bindValue("$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    /**
     * Undocumented function
     *
     * @param array $where
     * @param array $select
     * @return void
     */
    public static function deleteWhere(array $where)
    {
        $tableName = static::tableName();
        $where_statements = array_keys($where);

        $where_sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $where_statements));

        $statement = self::prepare("DELETE FROM $tableName WHERE $where_sql");

        foreach ($where as $key => $item) {
            $statement->bindValue("$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}
