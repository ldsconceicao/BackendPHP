<?php

namespace Reweb\Job\Backend;

/**
* Implementa a classe base para classes de contas
*/
class Conta
{
  protected int $codId;   //código identificador
  protected float $saldo;

  public function __construct(int $codId, float $saldo)
  {
    $this->codId = $codId;
    $this->saldo = $saldo;
  }

  public function getId()
  {
    return $this->codId;
  }

  public function getSaldo()
  {
    return $this->saldo;
  }

  public function deposito (float $valor)
  {
    if ($valor > 0) {
      $this->saldo = $this->saldo + $valor;
    }
    else {
      throw new \Exception("Valor negativo.");
    }
  }

  public function saque (float $valor)
  {
    if ($valor > 0) {
      if ($this->saldo >= ($valor + static::TAXA_SAQUE)) {
        if ($valor <= static::LIMITE_SAQUE) {
          $this->saldo = $this->saldo - ($valor + static::TAXA_SAQUE);
        }
        else {
          throw new \Exception("Valor do saque superior ao limite permitido.");
        }
      }
      else {
        throw new \Exception("Saldo insuficiente para o saque.");
      }
    }
    else {
      throw new \Exception("Valor negativo.");
    }
  }

  public function transferencia (float $valor, $conta)
  {
    if ($valor > 0) {
      if ($this->codId != $conta->codId) {
        if ($this->saldo >= $valor) {
          $this->saldo = $this->saldo - $valor;
          $conta->saldo = $conta->saldo + $valor;
        }
        else {
          throw new \Exception("Saldo insuficiente para a transferência.");
        }
      }
      else {
        throw new \Exception("Transferência para a mesma conta.");
      }
    }
    else {
      throw new \Exception("Valor negativo.");
    }
  }
}
