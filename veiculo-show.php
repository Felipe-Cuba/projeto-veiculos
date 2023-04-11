<?php

require './core/config/database.php';

require './core/models/veiculo.php';

$database = new Database();

if (isset($_GET['id'])) {
  $id = $_GET['id'];


  try {
    $database->connect();

    $result = $database->selectWhere('veiculos', ['*'], "id_veiculo = $id");
    $data = $result->fetchAll(PDO::FETCH_CLASS, "Veiculo");

    foreach ($data as $row) {
      $veiculo = $row;
    }

    $database->closeConnection();
  } catch (PDOException $error) {
    $flag_msg = false;
    $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
  }
} else {
  header('Location: index.php');
  exit();
}

require_once('./views/layouts/header_inc.php');
?>

<div class="p-4 mb-4 bg-light">
  <h1 class="display-5">Detalhes do Veículo</h1>

</div>

<div class="container">
  <div class="row">
    <div class="col-md-6 mb-4">
      <img src="<?= $veiculo->__get('foto') ?>" class="img-fluid rounded" alt="<?= $veiculo->__get('modelo') ?>">
    </div>
    <div class="col-md-6 mb-4">
      <table class="table">
        <tbody>
          <tr>
            <th>Marca:</th>
            <td><?= $veiculo->__get('marca') ?></td>
          </tr>
          <tr>
            <th>Modelo:</th>
            <td><?= $veiculo->__get('modelo') ?></td>
          </tr>
          <tr>
            <th>Ano de fabricação:</th>
            <td><?= $veiculo->__get('ano_fabricacao') ?></td>
          </tr>
          <tr>
            <th>Ano do modelo:</th>
            <td><?= $veiculo->__get('ano_modelo') ?></td>
          </tr>
          <tr>
            <th>Tipo de combustível:</th>
            <td><?= $veiculo->__get('combustivel') ?></td>
          </tr>
          <tr>
            <th>Preço:</th>
            <td>R$ <?= number_format($veiculo->__get('preco'), 2, ',', '.') ?></td>
          </tr>
          <tr>
            <th>Cor:</th>
            <td><?= $veiculo->__get('cor') ?></td>
          </tr>
        </tbody>
      </table>
      <div class="text-end">
        <a href="./index.php" class="btn btn-secondary">Voltar</a>
      </div>
    </div>
  </div>
</div>

<?php
require_once('./views/layouts/footer_inc.php');
?>