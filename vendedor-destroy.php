<?php

require './core/config/database.php';

$database = new Database();

if (isset($_GET['id'])) {
  $id = $_GET['id'];


  try {
    $database->connect();

    $database->delete('vendedores', "id_vendedor = $id");

    $database->closeConnection();
  } catch (PDOException $error) {
    $flag_msg = false;
    $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
  }
  header('Location: vendedores-list.php');
  exit();
} else {
  header('Location: index.php');
  exit();
}
