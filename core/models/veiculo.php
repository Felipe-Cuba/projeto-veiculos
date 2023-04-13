<?php

class Veiculo
{
  private int $id_veiculo;
  private string $marca;
  private string $modelo;
  private string $cor;
  private string $ano_fabricacao;
  private string $ano_modelo;
  private string $combustivel;
  private float $preco;
  private string $detalhes;
  private string $foto;

  public function __get($name)
  {

    if ($name === 'preco') {
      return number_format($this->$name, 2, ',', '.');
    } else {
      return $this->$name;
    }
  }

  public function __set($name, $value)
  {
    $this->$name = $value;
  }
}
