<?php

// Define o caminho absoluto para a raiz do projeto, utilizando o diretório raiz do servidor.
define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/ControleOs/ControleOsFuncionario/src/');

// Define a constante para a URL do script atual, sanitizando-a para evitar problemas de segurança.
define('PAG_SELF', htmlspecialchars($_SERVER["PHP_SELF"]));

// Definição de constantes que representam as situações possíveis de um chamado.
const SITUACAO_CHAMADO_TODOS = 0; // Representa todos os chamados, sem filtro.
const SITUACAO_CHAMADO_AGUARDANDO_ATENDIMENTO = 1; // Chamados que estão aguardando atendimento.
const SITUACAO_CHAMADO_EM_ATENDIMENTO = 2; // Chamados que estão em atendimento.
const SITUACAO_CHAMADO_FINALIZADO = 3; // Chamados que foram finalizados.

?>
