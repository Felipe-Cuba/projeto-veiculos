<?php

class Database
{
  private string $host;
  private string $user;
  private string $password;
  private string $dbname;
  private $conn;

  public function __construct()
  {
    $this->host = "localhost";
    $this->user = "root";
    $this->password = "";
    $this->dbname = "progwebveiculos";
  }

  public function connect()
  {
    $dsn = "mysql:host=$this->host;dbname=$this->dbname";
    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    try {
      $this->conn = new PDO($dsn, $this->user, $this->password, $options);
    } catch (PDOException $e) {
      echo "Erro de conexão: " . $e->getMessage();
    }
  }

  public function selectAll($table, $order = "", $limit = "")
  {
    $query = "SELECT * FROM $table";
    if (!empty($order)) {
      $query .= " ORDER BY $order";
    }
    if (!empty($limit)) {
      $query .= " LIMIT $limit";
    }
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function selectWhere($table, $fields, $where = "", $order = "", $limit = "")
  {
    $fields_str = implode(",", $fields);
    $query = "SELECT $fields_str FROM $table";
    if (!empty($where)) {
      $query .= " WHERE $where";
    }
    if (!empty($order)) {
      $query .= " ORDER BY $order";
    }
    if (!empty($limit)) {
      $query .= " LIMIT $limit";
    }
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


  public function insert($table, $data)
  {
    $keys = array_keys($data);
    $values = array_values($data);
    $fields = implode(",", $keys);
    $params = rtrim(str_repeat("?,", count($values)), ",");
    $query = "INSERT INTO $table ($fields) VALUES ($params)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute($values);
    return $stmt->rowCount();
  }

  public function update($table, $data, $where)
  {
    $set = "";
    foreach ($data as $key => $value) {
      $set .= "$key=?,";
    }
    $set = rtrim($set, ",");
    $query = "UPDATE $table SET $set WHERE $where";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(array_values($data));
    return $stmt->rowCount();
  }

  public function delete($table, $where)
  {
    $query = "DELETE FROM $table WHERE $where";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function lastInsertId()
  {
    return $this->conn->lastInsertId();
  }

  public function closeConnection()
  {
    $this->conn = null;
  }
}
