//#region ENDPOINTS

const TAMANHO_SENHA_PERMITIDA = 6;

const API_DETALHAR_USUARIO = 'DetalharUsuarioApi';
const API_GRAVAR_MEUS_DADOS = 'AlterarMeusDadosApi';
const API_VERIFICAR_SENHA_ATUAL = 'VerificarSenhaApi';
const API_ALTERAR_SENHA_ATUAL = 'AlterarSenhaUsuarioApi';
const API_LISTAR_EQUIPAMENTO_SETOR = 'EquipamentosAlocadosSetorApi';
const API_ABRIR_CHAMADO = 'AbrirChamadoApi';
const API_FILTRAR_CHAMADO = 'FiltrarChamadoApi';
const API_DETALHAR_CHAMADO = 'DetalharChamadoApi';
const API_ACESSAR = 'ValidarLoginApi';


//MENSAGENS DO AMBIENTE
const MSG_ERRO_CALL_API = "Erro ao chamar API";
const MSG_SENHA_INCORRETA = "Senha incorreta!";
const MSG_SUCCESSO = "Ação realizada com sucesso";
const MSG_ERRO = "Ocorreu um erro na operação, tente mais tarde!";
const MSG_CAMPO_VAZIO = "Por favor, preencha todos os campos!";
const MSG_COMPRIMENTO_SENHA = `Preencher a senha com no mínimo ${TAMANHO_SENHA_PERMITIDA} caracteres`;
const MSG_REPETIR_SENHA = "A senha e repetir senha não conferem";
const MSG_DADOS_NAO_ENCONTRADO = "Não foi encontrado nenhum registro";
const MSG_USUARIO_NAO_ENCONTRADO = "Usuário não foi encontrado!";
const MSG_CEP_NAO_ENCONTRADO = "CEP não foi encontrado!";
const MSG_NAO_ENCONTRADO = "Nenhum resultado encontrado.";

const COR_MSG_ATENCAO = 0;
const NAO_AUTORIZADO = -1000;
const COR_MSG_SUCESSO = 1;
const COR_MSG_ERROR = -1;
const COR_MSG_INFO = 2;

const AGUARDANDO_ATENDIMENTO = 'AGUARDANDO ATENDIMENTO';
const ATENDIMENTO_ENCERRADO = 'ENCERRADO';
const EM_ATENDIMENTO = 'EM ATENDIMENTO'

//#endregion