<?php
require_once('./views/layouts/header_inc.php');
?>
<main class="container">
  <h1>Bem-vindo ao nosso site</h1>
  <p>Aqui você encontra os melhores carros usados do mercado.</p>
  <hr>
  <h2>Últimos carros adicionados ao estoque:</h2>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card">
        <img class="card-img-top" src="./assets/images/gold.png" alt="Carro 1">
        <div class="card-body">
          <h5 class="card-title">Carro 1</h5>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend ipsum non turpis fringilla, a luctus velit pharetra.</p>
          <a href="#" class="btn btn-primary">Ver mais</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card">
        <img class="card-img-top" src="carro2.jpg" alt="Carro 2">
        <div class="card-body">
          <h5 class="card-title">Carro 2</h5>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend ipsum non turpis fringilla, a luctus velit pharetra.</p>
          <a href="#" class="btn btn-primary">Ver mais</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card">
        <img class="card-img-top" src="carro3.jpg" alt="Carro 3">
        <div class="card-body">
          <h5 class="card-title">Carro 3</h5>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend ipsum non turpis fringilla, a luctus velit pharetra.</p>
          <a href="#" class="btn btn-primary">Ver mais</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
require_once('./views/layouts/footer_inc.php');
?>