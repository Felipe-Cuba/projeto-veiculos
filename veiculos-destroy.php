<?php

require './core/config/database.php';

$database = new Database();

if (isset($_GET['id'])) {
  $id = $_GET['id'];


  try {
    $database->connect();

    $database->delete('veiculos', "id_veiculo = $id");

    $database->closeConnection();
  } catch (PDOException $error) {
    $flag_msg = false;
    $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
  }
  header('Location: veiculos-list.php');
  exit();
} else {
  header('Location: index.php');
  exit();
}
