<?php

define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/ControleOs/ControleOsTecnico/src/');
define('PAG_SELF', htmlspecialchars($_SERVER["PHP_SELF"]));

const SITUACAO_CHAMADO_TODOS = 0;
const SITUACAO_CHAMADO_AGUARDANDO_ATENDIMENTO = 1;
const SITUACAO_CHAMADO_EM_ATENDIMENTO = 2;
const SITUACAO_CHAMADO_FINALIZADO = 3;

?>