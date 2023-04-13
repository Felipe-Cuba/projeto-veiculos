<?php
require './core/config/database.php';

require './core/models/veiculo.php';

$flag_msg = null;
$msg = '';

$database = new Database();

try {
  $database->connect();

  $result = $database->selectAll('veiculos');
  $veiculos = $result->fetchAll(PDO::FETCH_CLASS, "Veiculo");


  $database->closeConnection();

  if (!(count($veiculos) > 0)) {
    $flag_msg = false;
    $msg = 'Não há veículos cadastrados';
  }
} catch (PDOException $error) {
  $flag_msg = false;
  $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
}

require_once('./views/layouts/header_inc.php');
?>

<div class="p-4 mb-4 bg-dark" style="color: white;">
  <h1 class="display-5">Gerenciamento de veículos</h1>
  <hr class="my-3">
  <p class="lead">Vizualização de todos os veículos, com a opção de adicionar, exibir, editar ou excluir um veículo.</p>
</div>

<div class="container">

  <a class="btn btn-success mb-3" href="./cadastro-veiculos.php">Cadastrar veículo</a>
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Ano de fabricação</th>
          <th>Ano do modelo</th>
          <th>Tipo de combustível</th>
          <th>Preço</th>
          <th>Cor</th>
          <th>Foto</th>
          <th>Detalhes</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($veiculos as $veiculo) { ?>
          <tr>
            <td><?= $veiculo->__get('id_veiculo') ?></td>
            <td><?= $veiculo->__get('marca') ?></td>
            <td><?= $veiculo->__get('modelo') ?></td>
            <td><?= $veiculo->__get('ano_fabricacao') ?></td>
            <td><?= $veiculo->__get('ano_modelo') ?></td>
            <td><?= $veiculo->__get('combustivel') ?></td>
            <td class="text-nowrap" >R$ <?= $veiculo->__get('preco') ?></td>
            <td><?= $veiculo->__get('cor') ?></td>
            <td><img src="<?= $veiculo->__get('foto') ?>" class="img-thumbnail" width="100" height="100" alt="Foto do veículo"></td>
            <td><a href="veiculo-show.php?id=<?= $veiculo->__get('id_veiculo') ?>"><button type="button" class="btn btn-primary">Exibir</button></a></td>
            <td class="text-nowrap">
              <a href="cadastro-veiculos.php?id=<?= $veiculo->__get('id_veiculo') ?>"><button type="button" class="btn btn-warning me-2">Editar</button></a>
              <a href="veiculos-destroy.php?id=<?= $veiculo->__get('id_veiculo') ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php
    if (!is_null($flag_msg)) {
      if ($flag_msg) {
        echo "<div class='alert alert-success mt-5' role='alert'>$msg</div>";
      } else {
        echo "<div class='alert alert-warning mt-5' role='alert'>$msg</div>";
      }
    }
    ?>
  </div>
</div>



<?php
require_once('./views/layouts/footer_inc.php');
?>