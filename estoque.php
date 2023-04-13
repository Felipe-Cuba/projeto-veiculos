<?php
require './core/config/database.php';

require './core/models/veiculo.php';

$flag_msg = null;
$msg = '';

$database = new Database();

$table = 'veiculos';
$selected = $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'marca';


$order = 'ASC';

if ($filtro === 'menor-preco') {
  $filtro = 'preco';
} elseif ($filtro === 'maior-preco') {
  $filtro = 'preco';
  $order = 'DESC';
}
try {
  $database->connect();

  $result = $database->selectAll($table, $filtro, $order);
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

  <div class="form-group my-4">
    <label for="filtro">Filtrar por:</label>
    <select class="form-control" id="filtro" name="filtro" onchange="filtrarPor()">
      <option value="marca" <?php if ($selected == 'marca') echo 'selected'; ?>>Marca</option>
      <option value="modelo" <?php if ($selected == 'modelo') echo 'selected'; ?>>Modelo</option>
      <option value="menor-preco" <?php if ($selected == 'menor-preco') echo 'selected'; ?>>Menor preço</option>
      <option value="maior-preco" <?php if ($selected == 'maior-preco') echo 'selected'; ?>>Maior preço</option>
    </select>
  </div>

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
            <p class="card-text"><i class="bi bi-currency-dollar"></i>R$ <?= $veiculo->__get('preco') ?></p>
            <a href="veiculo-show.php?id=<?= $veiculo->__get('id_veiculo') ?>" class="btn btn-primary">Ver mais</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</main>

<script>
  function filtrarPor() {
    const filtro = document.getElementById('filtro').value;
    window.location.href = `estoque.php?filtro=${filtro}`;
  }
</script>



<?php
require_once('./views/layouts/footer_inc.php');
?>