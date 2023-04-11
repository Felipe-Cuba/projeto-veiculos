<?php
require './core/config/database.php';

require './core/models/veiculo.php';

$database = new Database();

try {
  $database->connect();

  $result = $database->selectAll('veiculos', 'id_veiculo', 'ASC');
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

<style>
  .imagem-card {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }
</style>

<main class="container">
  <h1>Bem-vindo ao nosso estoque</h1>
  <p>Aqui você encontra os melhores carros usados do mercado.</p>
  <hr>

  <?php
  if (!is_null($flag_msg)) {
    if ($flag_msg) {
      echo "<div class='alert alert-success mt-5' role='alert'>$msg</div>";
    } else {
      echo "<div class='alert alert-warning mt-5' role='alert'>$msg</div>";
    }
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
            <p class="card-text"><i class="bi bi-currency-dollar"></i> <?= number_format($veiculo->__get('preco'), 2, ',', '.') ?></p>
            <a href="veiculo-show.php?id=<?= $veiculo->__get('id_veiculo') ?>" class="btn btn-primary">Ver mais</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</main>



<?php
require_once('./views/layouts/footer_inc.php');
?>