<?php

namespace Reweb\Job\Backend\Tests;

use Reweb\Job\Backend;

define('SALDO_TESTE_CP', 1 + Backend\ContaPoupanca::LIMITE_SAQUE +
        Backend\ContaPoupanca::TAXA_SAQUE);

/**
*  Teste unitário da classe Reweb\Job\Backend\ContaPoupanca
*/
class ContaPoupancaTest extends \PHPUnit_Framework_TestCase
{
  protected $conPoupanca;

  protected function setUp()
  {
    $this->conPoupanca = new Backend\ContaPoupanca(1, SALDO_TESTE_CP);
  }

  public function testDeposito()
  {
    $this->conPoupanca->deposito(25.55);
    $this->assertEquals(SALDO_TESTE_CP + 25.55, $this->conPoupanca->getSaldo());
  }

  public function testDepositoNegativo()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $this->conPoupanca->deposito(-1);
  }

  public function testSaque()
  {
    $this->conPoupanca->saque(25.55);
    $this->assertEquals(SALDO_TESTE_CP -
                        (25.55 + Backend\ContaPoupanca::TAXA_SAQUE),
                        $this->conPoupanca->getSaldo());
  }

  public function testSaqueNegativo()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $this->conPoupanca->saque(-1);
  }

  public function testSaqueSaldoInsuficiente()
  {
    $this->expectExceptionMessage("Saldo insuficiente para o saque.");
    $this->conPoupanca->saque(SALDO_TESTE_CP +
                              Backend\ContaPoupanca::TAXA_SAQUE + 1);
  }

  public function testSaqueSaldoLimite()
  {
    $this->expectExceptionMessage("Valor do saque superior ao limite permitido.");
    $this->conPoupanca->saque(Backend\ContaPoupanca::LIMITE_SAQUE + 0.1);
  }

  public function testTransferencia()
  {
    $conPoupanca2 = new Backend\ContaPoupanca(2, SALDO_TESTE_CP);
    $this->conPoupanca->transferencia(25.55, $conPoupanca2);
    $this->assertEquals(SALDO_TESTE_CP + 25.55,
                        $conPoupanca2->getSaldo());
  }

  public function testTransferenciaNegativa()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $conPoupanca2 = new Backend\ContaPoupanca(2, SALDO_TESTE_CP);
    $this->conPoupanca->transferencia(-1, $conPoupanca2);
  }

  public function testTransferenciaSaldoInsuficiente()
  {
    $this->expectExceptionMessage("Saldo insuficiente para a transferência.");
    $conPoupanca2 = new Backend\ContaPoupanca(2, SALDO_TESTE_CP);
    $this->conPoupanca->transferencia(SALDO_TESTE_CP + 0.1, $conPoupanca2);
  }

  public function testTransferenciaMesmaConta()
  {
    $this->expectExceptionMessage("Transferência para a mesma conta.");
    $this->conPoupanca->transferencia(1, $this->conPoupanca);
  }
}
