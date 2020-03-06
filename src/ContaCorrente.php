<?php

namespace Reweb\Job\Backend;

/**
* Implementa a classe para Contas Correntes
*/
class ContaCorrente extends Conta
{
  const LIMITE_SAQUE = 600;
  const TAXA_SAQUE = 2.5;
}
