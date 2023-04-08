<?php

class Vendedor
{
  private int $id;
  private string $nome;
  private string $email;
  private string $telefone;

  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    $this->$name = $value;
  }
}
