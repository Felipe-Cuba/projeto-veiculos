<?php
$flag_msg = null;
$msg = '';

require './core/config/database.php';

$database = new Database();

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  try {
    $database->connect();

    $result = $database->selectWhere('vendedores', ['*'], "id_vendedor = $id");
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
      $nome = $row['nome'];
      $email = $row['email'];
      $telefone = $row['telefone'];
    }

    $database->closeConnection();
  } catch (PDOException $error) {
    $flag_msg = false;
    $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
  }
}

if (isset($_POST['enviar'])) {
  $post = $_POST;

  $nome = $post['nome'];
  $email = $post['email'];
  $telefone = $post['telefone'];

  $form = [$nome, $email, $telefone];

  $aux = 0;

  foreach ($form as $field) {
    if (empty($field)) {
      $aux += 1;
    }
  }

  if ($aux >  0) {
    $flag_msg = false;
    $msg = 'Preencha todos os campos!';
  } else {
    $table = 'vendedores';
    $data = array(
      'nome' => $nome,
      'email' => $email,
      'telefone' => $telefone
    );

    try {
      $database->connect();

      $rows_affected = 0;

      if (isset($id) && !empty($id)) {
        $where = "id_vendedor = $id";
        $rows_affected = $database->update($table, $data, $where);
      } else {
        $rows_affected = $database->insert($table, $data);
      }

      $database->closeConnection();

      if ($rows_affected > 0) {
        $flag_msg = true;

        if (isset($id) && !empty($id))
          $msg = 'Vendedor atualizado com sucesso';
        else
          $msg = 'Vendedor cadastrado com sucesso';

        header('Location: vendedores-list.php');
      } else {
        $flag_msg = false;
        if (isset($id) && !empty($id))
          $msg = 'Algo deu errado na atualização!';
        else
          $msg = 'Algo deu errado no cadastro!';
      }
    } catch (PDOException $error) {
      $flag_msg = false;
      $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
    }
  }
}
require_once('./views/layouts/header_inc.php');
?>

<div class="p-4 mb-4 bg-light">
  <h1 class="display-5">Veículos</h1>
  <hr class="my-3">
  <p class="lead">Cadastre um novo veículo.</p>
</div>

<div class="container">
  <?php
  if (!is_null($flag_msg)) {
    if ($flag_msg) {
      echo "<div class='alert alert-success mt-5' role='alert'>$msg</div>";
    } else {
      echo "<div class='alert alert-warning mt-5' role='alert'>$msg</div>";
    }
  }
  ?>
  <div class="card my-5">
    <div class="card-body">
      <h1 class="card-title">Formulário de Cadastro de Vendedor</h1>
      <form action="" method="post" enctype="multipart/form-data" id="cadastro-veiculo">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" name="nome" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Telefone:</label>
          <input type="text" class="form-control" id="telefone" name="telefone" required value="<?php echo $telefone ?? ''; ?>">
        </div>
        <button type="submit" name="enviar" class="btn btn-primary"><?php if (isset($id)) echo 'Atualizar';
                                                                    else echo 'Cadastrar'; ?></button>
      </form>
    </div>
  </div>

</div>

<?php require_once('./views/layouts/footer_inc.php'); ?>