<?php
require_once('./views/layouts/header_inc.php');
$contatos = [1, 2, 3, 4];
?>

<div class="p-4 mb-4 bg-light">
  <h1 class="display-5">Gerenciamento de veículos</h1>
  <hr class="my-3">
  <p class="lead">Permite a criação, edição e a exclusão dos veículos cadastrados.</p>
</div>

<div class="container">
  <a class="btn btn-success mb-3" href="./cadastro-veiculos.php">Cadastrar veículo</a>
  <table class="table table-striped table-hover">
    <thead>
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
      <?php foreach ($contatos as $contato) { ?>
        <tr>
          <td><?= $contato ?></td>
          <td>Fabricante</td>
          <td>Modelo</td>
          <td>2010</td>
          <td>2010</td>
          <td>Gasolina</td>
          <td>R$ 35.000,00</td>
          <td>Vermelho</td>
          <td>./assets/images/golf.png</td>
          <td><a href="contato-show.php?id=1"><button type="button" class="btn btn-primary">Exibir</button></a></td>
          <td>
            <a href="contato-edit.php?id=1"><button type="button" class="btn btn-warning me-2">Editar</button></a>
            <a href="contato-destroy.php?id=1"><button type="button" class="btn btn-danger">Excluir</button></a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>


<?php
require_once('./views/layouts/footer_inc.php');
?>