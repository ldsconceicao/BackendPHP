<?php

require_once __DIR__ . '/vendor/autoload.php';

use Reweb\Job\Backend;

//uma pequena demonstação da interação entre os dois tipos de conta
$contaCor = new Backend\ContaCorrente(1,100);
$contaPou = new Backend\ContaPoupanca(2,100);
var_dump ($contaCor);
var_dump ($contaPou);
$contaCor->transferencia(50, $contaPou);
var_dump ($contaCor);
var_dump ($contaPou);
