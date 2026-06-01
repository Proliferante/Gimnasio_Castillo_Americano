<?php

namespace App\Base;

use PDO;

abstract class Model implements \ArrayAccess
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';
    protected array $attributes = [];
    protected array $original = [];
    protected bool $exists = false;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    // --- ArrayAccess ---

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    public function getId(): ?int
    {
        $pk = static::$primaryKey;
        return isset($this->attributes[$pk]) ? (int) $this->attributes[$pk] : null;
    }

    // --- Query methods ---

    public static function db(): Database
    {
        return Database::getInstance();
    }

    public static function pdo(): PDO
    {
        return Database::connection();
    }

    public static function find(int|string $id): ?static
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        $data = static::db()->fetch("SELECT * FROM $table WHERE $pk = ?", [$id]);
        return $data ? new static($data) : null;
    }

    public static function findAll(string $where = '', array $params = [], string $order = ''): array
    {
        $table = static::$table;
        $sql = "SELECT * FROM $table";
        if ($where) $sql .= " WHERE $where";
        if ($order) $sql .= " ORDER BY $order";
        $rows = static::db()->fetchAll($sql, $params);
        return array_map(fn($row) => new static($row), $rows);
    }

    public static function where(string $column, mixed $value): array
    {
        return static::findAll("$column = ?", [$value]);
    }

    public static function count(string $where = '', array $params = []): int
    {
        $table = static::$table;
        $sql = "SELECT COUNT(*) FROM $table";
        if ($where) $sql .= " WHERE $where";
        return (int) static::db()->fetch($sql, $params)['COUNT(*)'];
    }

    public static function query(string $sql, array $params = []): array
    {
        return static::db()->fetchAll($sql, $params);
    }

    public static function queryOne(string $sql, array $params = []): ?array
    {
        return static::db()->fetch($sql, $params);
    }

    // --- Persistence ---

    public function save(): bool
    {
        $pk = static::$primaryKey;
        $table = static::$table;

        if ($this->exists && isset($this->attributes[$pk])) {
            $id = $this->attributes[$pk];
            $data = $this->attributes;
            unset($data[$pk]);
            static::db()->update($table, $data, "$pk = :$pk", [$pk => $id]);
            return true;
        }

        $id = static::db()->insert($table, $this->attributes);
        if ($id) {
            $this->attributes[$pk] = $id;
            $this->exists = true;
            return true;
        }

        return false;
    }

    public function delete(): bool
    {
        $pk = static::$primaryKey;
        if (!$this->exists || !isset($this->attributes[$pk])) {
            return false;
        }
        static::db()->delete(static::$table, "$pk = ?", [$this->attributes[$pk]]);
        $this->exists = false;
        return true;
    }

    public static function raw(string $sql, array $params = []): \PDOStatement
    {
        return static::db()->query($sql, $params);
    }
}
