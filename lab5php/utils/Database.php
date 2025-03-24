<?php
class Database
{
    private $pdo;
    private $dbPath;

    public function __construct()
    {
        $this->dbPath = __DIR__ . '/../db/lab4and5php.db';
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO(
                "sqlite:{$this->dbPath}",
                null,
                null,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return true;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function insert($table, $columns, $values)
    {
        try {
            if (!$this->pdo) {
                $this->connect();
            }

            $placeholders = str_repeat('?,', count($values) - 1) . '?';
            $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES ({$placeholders})";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            throw new Exception("Insert failed: " . $e->getMessage());
        }
    }

    public function select($table, $columns = '*', $where = null, $params = [])
    {
        try {
            if (!$this->pdo) {
                $this->connect();
            }

            $sql = "SELECT {$columns} FROM {$table}";
            if ($where) {
                $sql .= " WHERE {$where}";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Select failed: " . $e->getMessage());
        }
    }

    public function update($table, $email, $fields, $values)
    {
        try {
            if (!$this->pdo) {
                $this->connect();
            }

            $setClause = implode('=?,', $fields) . '=?';
            $values[] = $email;
            $sql = "UPDATE {$table} SET {$setClause} WHERE Email = ?";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            throw new Exception("Update failed: " . $e->getMessage());
        }
    }

    public function delete($table, $email)
    {
        try {
            if (!$this->pdo) {
                $this->connect();
            }

            $sql = "DELETE FROM {$table} WHERE Email = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$email]);
        } catch (Exception $e) {
            throw new Exception("Delete failed: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
