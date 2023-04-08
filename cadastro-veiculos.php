<?php
$flag_msg = null;

if (isset($_POST['enviar'])) {
  
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
          <input type="text" class="form-control" id="marca" name="marca" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Modelo:</label>
          <input type="text" class="form-control" id="modelo" name="modelo" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Ano de fabricacao:</label>
          <input type="text" class="form-control" id="ano_fabricacao" name="ano_fabricacao" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Ano do modelo:</label>
          <input type="text" class="form-control" id="ano_modelo" name="ano_modelo" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Tipo de combustivel:</label>
          <input type="text" class="form-control" id="tipo_combustivel" name="tipo_combustivel" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Preço:</label>
          <input type="text" class="form-control" id="preco" name="preco" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Cor:</label>
          <input type="text" class="form-control" id="cor" name="cor" required value="<?php echo $nome ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="descricao" class="form-label">Detalhes:</label>
          <textarea class="form-control" id="detalhes" name="detalhes" rows="3" required><?php echo $descricao ?? ''; ?></textarea>

        </div>
        <div class="mb-3">
          <label for="imagem" class="form-label">Imagem:</label>
          <input type="file" class="form-control" id="imagem" name="imagem" onchange="previewImagem();" <?php if (isset($item_id)) echo '';
                                                                                                        else echo 'required'; ?>>
          <img id="preview" class="mt-3" style="max-width: 100%;" style="display:none">
        </div>
        <button type="submit" name="enviar" class="btn btn-primary"><?php if (isset($item_id)) echo 'Atualizar';
                                                      else echo 'Cadastrar'; ?></button>
      </form>
    </div>
  </div>

</div>

<script>
  function previewImagem() {
    var imagem = document.querySelector('input[name=imagem]').files[0];
    var preview = document.querySelector('#preview');
    var reader = new FileReader();

    reader.onloadend = function() {
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