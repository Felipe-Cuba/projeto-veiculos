<?php
require './core/config/database.php';

require './core/models/veiculo.php';
require './core/models/vendedor.php';

$veiculos_flag_msg = null;
$veiculo_msg = '';

$vendedores_flag_msg = null;
$vendedores_msg = '';

$database = new Database();

try {
  $database->connect();

  $result = $database->selectAll('veiculos', 'id_veiculo', 'DESC', '3');
  $veiculos = $result->fetchAll(PDO::FETCH_CLASS, "Veiculo");

  $database->closeConnection();

  if (!(count($veiculos) > 0)) {
    $veiculos_flag_msg = false;
    $veiculo_msg = 'Não há veículos cadastrados';
  }
} catch (PDOException $error) {
  $veiculos_flag_msg = false;
  $veiculo_msg = 'Erro ao buscar os veiculos!' . $error->getMessage();
}

try {
  $database->connect();

  $result = $database->selectAll('vendedores', 'id_vendedor');
  $vendedores = $result->fetchAll(PDO::FETCH_CLASS, "Vendedor");

  $database->closeConnection();

  if (!(count($veiculos) > 0)) {
    $vendedores_flag_msg = false;
    $vendedores_msg = 'Não há vendedores cadastrados';
  }
} catch (PDOException $error) {
  $vendedores_flag_msg = false;
  $vendedores_msg = 'Erro ao buscar os vendedores!' . $error->getMessage();
}

require_once('./views/layouts/header_inc.php');
?>

<style>
  .imagem-card {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }
</style>

<main class="container">

  <h1>Bem-vindo ao nosso site</h1>
  <p>Aqui você encontra os melhores carros usados do mercado.</p>
  <hr>
  <h2>Últimos carros adicionados ao estoque:</h2>

  <?php
  if (!is_null($veiculos_flag_msg)) {
    echo "<div class='alert alert-warning mt-5' role='alert'>$veiculo_msg</div>";
  }
  ?>

  <div class="row">
    <?php foreach ($veiculos as $veiculo) { ?>
      <div class="col-md-4 mb-4 card-veiculo">
        <div class="card shadow-lg bg-dark">
          <img class="card-img img-fluid imagem-card" src="<?= $veiculo->__get('foto') ?>" alt="Foto do veículo">
          <div class="card-body text-white">
            <h5 class="card-title"><?= $veiculo->__get('modelo') ?></h5>
            <hr class="bg-white">
            <p class="card-text"><?= $veiculo->__get('marca') ?></p>
            <p class="card-text"><i class="bi bi-currency-dollar"></i>R$ <?= $veiculo->__get('preco') ?></p>
            <a href="veiculo-show.php?id=<?= $veiculo->__get('id_veiculo') ?>" class="btn btn-primary">Ver mais</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="row my-5">
    <div class="col-md-12">
      <h2>Colsute nossos vendedores:</h2>
      <?php
      if (!is_null($vendedores_flag_msg)) {
        echo "<div class='alert alert-warning mt-5' role='alert'>$vendedores_msg</div>";
      }
      ?>
      <hr>
    </div>
    <div class="col-md-12">
      <ul class="list-group ">
        <?php foreach ($vendedores as $vendedor) { ?>
          <li class="list-group-item d-flex justify-content-between align-items-center item-vendedor">
            <div>
              <h5 class="mb-0"><?= $vendedor->__get('nome') ?></h5>
              <small class="text-muted"><?= $vendedor->__get('email') ?></small>
            </div>
            <span class="badge badge-primary badge-pill item-vendedor-telefone"><?= $vendedor->__get('telefone') ?></span>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>


</main>



<?php
require_once('./views/layouts/footer_inc.php');
?>