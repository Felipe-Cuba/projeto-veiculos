<?php
require './core/config/database.php';

require './core/models/vendedor.php';

$database = new Database();
$flag_msg = null;
try {
  $database->connect();

  $result = $database->selectAll('vendedores');
  $vendedores = $result->fetchAll(PDO::FETCH_CLASS, "Vendedor");

  $database->closeConnection();

  if (!(count($vendedores) > 0)) {
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
  <h1 class="display-5">Gerenciamento de vendedores</h1>
  <hr class="my-3">
  <p class="lead">Vizualização de todos os vendedores, com a opção de adicionar, exibir, editar ou excluir um vendedor.</p>
</div>

<div class="container">
  <a class="btn btn-success mb-3" href="./cadastro-vendedor.php">Cadastrar vendedor</a>
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vendedores as $vendedor) { ?>
          <tr>
            <td><?= $vendedor->__get('id_vendedor') ?></td>
            <td><?= $vendedor->__get('nome') ?></td>
            <td><?= $vendedor->__get('email') ?></td>
            <td><?= $vendedor->__get('telefone') ?></td>
            <td class="text-nowrap">
              <a href="cadastro-vendedor.php?id=<?= $vendedor->__get('id_vendedor') ?>"><button type="button" class="btn btn-warning me-2">Editar</button></a>
              <a href="vendedor-destroy.php?id=<?= $vendedor->__get('id_vendedor') ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
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