<?php


namespace app\core;


abstract class DBModel extends Model
{
	abstract public function tableName(): string;

	abstract public function attributes(): array;

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
}