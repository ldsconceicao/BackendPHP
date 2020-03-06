<?php

namespace Reweb\Job\Backend;

/**
* Implementa a classe para Contas Poupança
*/
class ContaPoupanca extends Conta
{
  const LIMITE_SAQUE = 1000;
  const TAXA_SAQUE = 0.80;
}
