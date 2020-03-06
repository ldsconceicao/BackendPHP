<?php

namespace Reweb\Job\Backend\Tests;

use Reweb\Job\Backend;

define('SALDO_TESTE_CC', 1 + Backend\ContaCorrente::LIMITE_SAQUE +
        Backend\ContaCorrente::TAXA_SAQUE);

/**
*  Teste unitário da classe Reweb\Job\Backend\ContaCorrente
*/
class ContaCorrenteTest extends \PHPUnit_Framework_TestCase
{
  protected $conCorrente;

  protected function setUp()
  {
    $this->conCorrente = new Backend\ContaCorrente(1, SALDO_TESTE_CC);
  }

  public function testDeposito()
  {
    $this->conCorrente->deposito(25.55);
    $this->assertEquals(SALDO_TESTE_CC + 25.55, $this->conCorrente->getSaldo());
  }

  public function testDepositoNegativo()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $this->conCorrente->deposito(-1);
  }

  public function testSaque()
  {
    $this->conCorrente->saque(25.55);
    $this->assertEquals(SALDO_TESTE_CC -
                        (25.55 + Backend\ContaCorrente::TAXA_SAQUE),
                        $this->conCorrente->getSaldo());
  }

  public function testSaqueNegativo()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $this->conCorrente->saque(-1);
  }

  public function testSaqueSaldoInsuficiente()
  {
    $this->expectExceptionMessage("Saldo insuficiente para o saque.");
    $this->conCorrente->saque(SALDO_TESTE_CC +
                              Backend\ContaCorrente::TAXA_SAQUE + 1);
  }

  public function testSaqueSaldoLimite()
  {
    $this->expectExceptionMessage("Valor do saque superior ao limite permitido.");
    $this->conCorrente->saque(Backend\ContaCorrente::LIMITE_SAQUE + 0.1);
  }

  public function testTransferencia()
  {
    $conCorrente2 = new Backend\ContaCorrente(2, SALDO_TESTE_CC);
    $this->conCorrente->transferencia(25.55, $conCorrente2);
    $this->assertEquals(SALDO_TESTE_CC + 25.55,
                        $conCorrente2->getSaldo());
  }

  public function testTransferenciaNegativa()
  {
    $this->expectExceptionMessage("Valor negativo.");
    $conCorrente2 = new Backend\ContaCorrente(2, SALDO_TESTE_CC);
    $this->conCorrente->transferencia(-1, $conCorrente2);
  }

  public function testTransferenciaSaldoInsuficiente()
  {
    $this->expectExceptionMessage("Saldo insuficiente para a transferência.");
    $conCorrente2 = new Backend\ContaCorrente(2, SALDO_TESTE_CC);
    $this->conCorrente->transferencia(SALDO_TESTE_CC + 0.1, $conCorrente2);
  }

  public function testTransferenciaMesmaConta()
  {
    $this->expectExceptionMessage("Transferência para a mesma conta.");
    $this->conCorrente->transferencia(1, $this->conCorrente);
  }
}
