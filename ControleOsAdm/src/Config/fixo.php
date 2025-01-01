<?php

//Variavel que armazena o caminho da pasta do diretório pai do projeto 
define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/ControleOS/ControleOsAdm/src/');

const NAO_AUTORIZADO = 'Não Autorizado';

//USUARIO
const CADASTRAR_USUARIO = 'CadastrarUsuario';
const ALTERAR_USUARIO = 'AlterarUsuario';
const ALTERAR_STATUS_USUARIO = 'AlterarStatusUsuario';

//Situação do equipamento
const SITUACAO_ATIVO = 1;
const SITUACAO_INATIVO = 0;
const SITUACAO_DESCARTADO = 0;

//Flags Chamados
const SITUACAO_CHAMADO_TODOS = 0;
const SITUACAO_CHAMADO_AGUARDANDO_ATENDIMENTO = 1;
const SITUACAO_CHAMADO_EM_ATENDIMENTO = 2;
const SITUACAO_CHAMADO_FINALIZADO = 1;

//Alocamento
const SITUACAO_EQUIPAMENTO_ALOCADO = 1;
const SITUACAO_EQUIPAMENTO_DESCARTADO = 2;
const SITUACAO_EQUIPAMENTO_MANUTENCAO = 3;

//Tipos de Usuario
const USUARIO_ADM = 1;
const USUARIO_FUNCIONARIO = 2;
const USUARIO_TECNICO = 3;

//Status Usuário
const USUARIO_ATIVO = 1;
const USUARIO_INATIVO = 2;

//Função do erro
//Setor Equipamento
const CADASTRAR_SETOR_EQUIPAMENTO = 'CadastrarSetorEquipamento';
const ALTERAR_SETOR_EQUIPAMENTO = 'AlterarSetorEquipamento';
const EXCLUIR_SETOR_EQUIPAMENTO = 'ExcluirSetorEquipamento';

//Tipo Equipamento
const CADASTRAR_TIPO_EQUIPAMENTO = 'CadastrarTipoEquipamento';
const ALTERAR_TIPO_EQUIPAMENTO = 'AlterarTipoEquipamento';
const EXCLUIR_TIPO_EQUIPAMENTO = 'ExcluirTipoEquipamento';

//Modelo Equipamento
const CADASTRAR_MODELO_EQUIPAMENTO = 'CadastrarModeloEquipamento';
const ALTERAR_MODELO_EQUIPAMENTO = 'AlterarModeloEquipamento';
const EXCLUIR_MODELO_EQUIPAMENTO = 'ExcluirModeloEquipamento';

const ATENDER_CHAMADO = 'AtenderChamado';
const FINALIZAR_CHAMADO = 'FinalizarChamado';
//Equipamento
const CADASTRAR_EQUIPAMENTO = 'CadastrarEquipamento';
const ALTERAR_EQUIPAMENTO = 'AlterarEquipamento';
const EXCLUIR_EQUIPAMENTO = 'ExcluirEquipamento';
const DESCARTAR_EQUIPAMENTO = 'DescartarEquipamento';
const ALOCAR_EQUIPAMENTO = 'AlocarEquipamento';
const REMOVER_EQUIPAMENTO_ALOCADO = 'removerEquipamentoAlocado';

//Estado da tela equipamento ALTERAR ou CADASTRAR
const EQUIPAMENTO_CADASTRAR = 'Cadastrar';
const EQUIPAMENTO_ALTERAR = 'Alterar';

const SECRET_JWT = "turmaavaçado2023";
?>