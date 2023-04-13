<?php

class Vendedor
{
  private int $id_vendedor;
  private string $nome;
  private string $email;
  private string $telefone;

  public function __get($name)
  {
    if ($name === 'telefone') {
      return $this->formatarTelefone($this->$name);
    } else {
      return $this->$name;
    }
  }

  public function __set($name, $value)
  {

    $this->$name = $value;
  }

  private function formatarTelefone($telefone)
  {
    $ddd = substr($telefone, 0, 2);
    $parte1 = substr($telefone, 2, 5);
    $parte2 = substr($telefone, 7, 4);
    return "($ddd) $parte1-$parte2";
  }
}
