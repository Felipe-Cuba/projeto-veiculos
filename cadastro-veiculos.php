<?php
$flag_msg = null;
$msg = '';

require './core/config/database.php';

$database = new Database();

$caminho_arquivo = '';


if (isset($_GET['id'])) {
  $id = $_GET['id'];


  try {
    $database->connect();

    $result = $database->selectWhere('veiculos', ['*'], "id_veiculo = $id");
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
      $marca = $row['marca'];
      $modelo = $row['modelo'];
      $ano_fabricacao = $row['ano_fabricacao'];
      $ano_modelo = $row['ano_modelo'];
      $tipo_combustivel = $row['combustivel'];
      $preco = $row['preco'];
      $cor = $row['cor'];
      $detalhes = $row['detalhes'];
      $caminho_arquivo = $row['foto'];
    }

    $database->closeConnection();
  } catch (PDOException $error) {
    $flag_msg = false;
    $msg = 'Erro na conexão com o Banco de dados!' . $error->getMessage();
  }
}

if (isset($_POST['enviar'])) {

  $post = $_POST;

  $marca = $post['marca'];
  $modelo = $post['modelo'];
  $ano_fabricacao = $post['ano_fabricacao'];
  $ano_modelo = $post['ano_modelo'];
  $tipo_combustivel = $post['tipo_combustivel'];
  $preco = $post['preco'];
  $cor = $post['cor'];
  $detalhes = $post['detalhes'];

  $preco = str_replace("R$ ", "", $preco);
  $preco = str_replace(".", "", $preco);
  $preco = str_replace(",", ".", $preco);
  $preco = floatval($preco);

  $form = [$marca, $modelo, $ano_fabricacao, $ano_modelo, $tipo_combustivel, $preco, $cor];


  if (isset($_FILES['imagem'])) {
    $file = $_FILES['imagem'];

    $no_file = $file['error'] === UPLOAD_ERR_NO_FILE;

    $file_size = $file['size'];

    $upload_ok = $file['error'] === UPLOAD_ERR_OK;
  }

  $aux = 0;

  foreach ($form as $field) {
    if (empty($field)) {
      $aux += 1;
    }
  }


  if ($aux > 0) {
    $flag_msg = false;
    $msg = 'Preencha todos os campos!';
  } else {
    if ($no_file && (!isset($id) || empty($id))) {
      $flag_msg = false;
      $msg = 'Envie uma imagem!';
    } else {
      if ($file_size > 0 && $upload_ok) {

        $diretorio = 'assets/upload/';

        try {
          if (!file_exists($diretorio)) { // verifica se pasta upload existe
            mkdir($diretorio); // caso não exista ele cria a pasta
          }

          $nome_arquivo = time() . '-' . $file['name'];
          $caminho_arquivo = $diretorio . $nome_arquivo;
          move_uploaded_file($file['tmp_name'], $caminho_arquivo);

        } catch (Exception $error) {
          $flag_msg = false;
          $msg = 'Erro ao salvar a imagem' . $error->getMessage();
        }
      }

      $table = 'veiculos';



      $data = array(
        'marca' => $marca,
        'modelo' => $modelo,
        'cor' => $cor,
        'ano_fabricacao' => $ano_fabricacao,
        'ano_modelo' => $ano_modelo,
        'combustivel' => $tipo_combustivel,
        'preco' => $preco,
        'detalhes' => $detalhes,
        'foto' => $caminho_arquivo
      );

      try {
        $database->connect();

        $rows_affected = 0;

        if (isset($id) && !empty($id)) {
          $where = "id_veiculo = $id";
          $result = $database->update($table, $data, $where);
        } else {
          $result = $database->insert($table, $data);
        }

        $database->closeConnection();


        if ($result) {
          ignore_user_abort(true);
          sleep(2);

          header('Location: veiculos-list.php');
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
      <h1 class="card-title">Formulário de Cadastro de Veículo</h1>
      <form action="" method="post" enctype="multipart/form-data" id="cadastro-veiculo">
        <div class="mb-3">
          <label for="nome" class="form-label">Marca:</label>
          <input type="text" class="form-control" id="marca" name="marca" required value="<?php echo $marca ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Modelo:</label>
          <input type="text" class="form-control" id="modelo" name="modelo" required
            value="<?php echo $modelo ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Ano de fabricacao:</label>
          <input type="text" class="form-control" id="ano_fabricacao" name="ano_fabricacao" required
            value="<?php echo $ano_fabricacao ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Ano do modelo:</label>
          <input type="text" class="form-control" id="ano_modelo" name="ano_modelo" required
            value="<?php echo $ano_modelo ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Tipo de combustivel:</label>
          <input type="text" class="form-control" id="tipo_combustivel" name="tipo_combustivel" required
            value="<?php echo $tipo_combustivel ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Preço:</label>
          <input type="text" class="form-control" id="preco" name="preco" required value="<?php echo $preco ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Cor:</label>
          <input type="text" class="form-control" id="cor" name="cor" required value="<?php echo $cor ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Detalhes:</label>
          <textarea class="form-control" id="detalhes" name="detalhes"
            rows="3"><?php echo $detalhes ?? ''; ?></textarea>

        </div>
        <div class="mb-3">
          <label for="imagem" class="form-label">Imagem:</label>
          <input type="file" class="form-control" id="imagem" name="imagem" onchange="previewImagem();" <?php if (isset($id))
            echo '';
          else
            echo 'required'; ?>>
          <img id="preview" class="mt-3" style="max-width: 100%;" style="display:none">
        </div>
        <button type="submit" name="enviar" class="btn btn-primary">
          <?php if (isset($id))
            echo 'Atualizar';
          else
            echo 'Cadastrar'; ?>
        </button>
      </form>
    </div>
  </div>

</div>

<script src="assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>

<script>
  $(function () {
    $('#preco').maskMoney({
      prefix: 'R$ ',
      allowNegative: true,
      thousands: '.', decimal: ',',
      affixesStay: true
    });
  })

  function previewImagem() {
    var imagem = document.querySelector('input[name=imagem]').files[0];
    var preview = document.querySelector('#preview');
    var reader = new FileReader();

    reader.onloadend = function () {
      preview.src = reader.result;
      preview.style.display = "block";
      preview.style.margin = "auto";
      // preview.style.maxWidth = "10%"; // Definindo largura máxima de 25%
    }

    if (imagem) {
      reader.readAsDataURL(imagem);
    } else {
      preview.src = "";
      preview.style.display = "none";
    }
  }
</script>
<?php require_once('./views/layouts/footer_inc.php'); ?>