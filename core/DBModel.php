<?php

declare(strict_types=1);

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
    public function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function save(): bool
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
    public static function selectWhere(array $where, array $select = []): Model
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
}
