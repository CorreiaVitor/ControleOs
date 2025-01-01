<?php

namespace Src\Controller;

use Src\Model\UsuarioModel;
use Src\public\Util;
use Src\VO\UsuarioVO;

class UsuarioCtrl
{
    private $model;

    // Construtor que inicializa o model
    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    // Verifica se o e-mail já está cadastrado
    public function VerificarEmailCadastradoCtrl($email_usuario): bool
    {
        if (empty($email_usuario)) {
            return 0; // Retorna falso se o e-mail estiver vazio
        }

        return $this->model->VerificarEmailCadastradoModel($email_usuario);
    }

    // Verifica se o CPF já está cadastrado
    public function VerificarCpfCadastradoCtrl($cpf_usuario): bool
    {
        if (empty($cpf_usuario)) {
            return 0; // Retorna falso se o CPF estiver vazio
        }

        // Trata o CPF antes de enviar para o model
        return $this->model->VerificarCpfCadastradoModel(Util::TratarDadosGerais($cpf_usuario));
    }

    // Cadastra um novo usuário no sistema
    public function CadastrarUsuarioCtrl($useVO): int
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (
            empty($useVO->getNome()) ||
            empty($useVO->getTipo()) ||
            empty($useVO->getEmail()) ||
            empty($useVO->getCpf()) ||
            empty($useVO->getTelefone())
        ) {
            return 0;
        }

        // Regras adicionais para técnicos e funcionários
        if ($useVO->getTipo() == USUARIO_TECNICO && empty($useVO->getNomeEmpresa())) {
            return 0;
        }

        if ($useVO->getTipo() == USUARIO_FUNCIONARIO && empty($useVO->getIdSetor())) {
            return 0;
        }

        // Configurações adicionais do usuário antes do cadastro
        $useVO->setFuncaoErro(CADASTRAR_USUARIO);
        $useVO->setUserLog(Util::UsuarioLog());
        $useVO->setStatus(SITUACAO_ATIVO);
        $useVO->setSenha(Util::CriptografarSenha($useVO->getCpf()));

        return $this->model->CadastrarUsuarioModel($useVO);
    }

    // Altera os dados de um usuário existente
    public function AlterarUsuarioCtrl($useVO, bool $tem_sessao = true): int
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (
            empty($useVO->getNome()) ||
            empty($useVO->getEmail()) ||
            empty($useVO->getCpf()) ||
            empty($useVO->getRua()) ||
            empty($useVO->getBairro()) ||
            empty($useVO->getCep()) ||
            empty($useVO->getCidade()) ||
            empty($useVO->getEstado()) ||
            empty($useVO->getTelefone())
        ) {
            return 0;
        }

        // Regras adicionais para técnicos
        if ($useVO->getTipo() == USUARIO_TECNICO && empty($useVO->getNomeEmpresa())) {
            return 0;
        }

        // Configurações adicionais antes de alterar o usuário
        $useVO->setFuncaoErro(ALTERAR_USUARIO);
        $useVO->setUserLog($tem_sessao ? Util::UsuarioLog() : $useVO->getId());
        $useVO->setSenha(Util::CriptografarSenha($useVO->getCpf()));

        return $this->model->AlterarUsuarioModel($useVO);
    }

    // Valida as credenciais do login
    public function ValidarLoginCtrl(string $login, string $senha)
    {
        if (empty($login) || empty($senha)) {
            return 0; // Campos obrigatórios não preenchidos
        }

        $usuario = $this->model->ValidarLoginModel($login, SITUACAO_ATIVO);

        // Verifica se o login foi encontrado
        if (empty($usuario)) {
            return -9; // Retorna erro
        }

        // Verifica se a senha está correta
        if (!Util::VerificarSenha($senha, $usuario['senha_usuario'])) {
            return -9; // Senha incorreta
        }

        // Registra o acesso e cria a sessão
        $this->model->RegistrarLogAcesso(Util::DataHoraAtual(), $usuario['id_usuario']);
        Util::CriarSessao($usuario['id_usuario'], $usuario['nome_usuario']);
        Util::ChamarPagina('http://localhost/ControleOs/ControleOsAdm/src/View/admin/index');
    }

    // Valida login específico para API
    public function ValidarLoginApiCtrl(string $login, string $senha)
    {
        if (empty($login) || empty($senha)) {
            return 0; // Campos obrigatórios não preenchidos
        }

        $usuario = $this->model->ValidarLoginModel($login, SITUACAO_ATIVO);

        if (empty($usuario)) {
            return -9; // Login não encontrado
        }

        if (!Util::VerificarSenha($senha, $usuario['senha_usuario'])) {
            return -9; // Senha incorreta
        }

        // Registra o log e cria o token para autenticação na API
        $this->model->RegistrarLogAcesso(Util::DataHoraAtual(), $usuario['id_usuario']);
        $dados_usuario = [
            'cod_user' => $usuario['id_usuario'],
            'nome' => $usuario['nome_usuario'],
            'cod_setor' => $usuario['setor_id']
        ];

        $token = Util::CreateTokenAuthentication($dados_usuario);

        return $token;
    }

    // Filtra usuários pelo nome
    public function FiltrarUsuarioCtrl(string $nome_usuario): array
    {
        return $this->model->FiltrarUsuarioModel($nome_usuario);
    }

    // Detalha as informações de um usuário
    public function DetalharUsuarioCtrl(int $id_usuario): array | int | bool
    {
        if ($id_usuario == '' || $id_usuario < 0) {
            return 0; // ID inválido
        }

        return $this->model->DetalharUsuarioModel($id_usuario);
    }

    // Inativa ou reativa um usuário
    public function InativarUsuarioCtrl(UsuarioVO $userVO): int
    {
        $userVO->setFuncaoErro(ALTERAR_STATUS_USUARIO);
        $userVO->setStatus($userVO->getStatus() == USUARIO_ATIVO ? USUARIO_INATIVO : USUARIO_ATIVO);

        return $this->model->InativarUsuarioModel($userVO);
    }

    // Verifica se a senha do usuário está correta
    public function VerificarSenhaUsuarioCtrl(int $id, $senha_digitada): int
    {
        $dados = $this->model->BuscarSenhaUsuarioModel($id);

        if (empty($dados)) {
            return -1; // Usuário não encontrado
        } else {
            $senha_hash = $dados['senha_usuario'];
            return !Util::VerificarSenha($senha_digitada, $senha_hash) ? -1 : 1; // Retorna 1 se a senha estiver correta
        }
    }

    // Altera a senha do usuário
    public function AlterarSenhaUsuarioCtrl(UsuarioVO $vo, bool $tem_sessao = true): int
    {
        if (empty($vo->getSenha()) || empty($vo->getId())) {
            return 0; // Campos obrigatórios não preenchidos
        }

        $vo->setSenha(Util::CriptografarSenha($vo->getSenha()));
        $vo->setUserlog($tem_sessao ? Util::UsuarioLog() : $vo->getId());

        return $this->model->AlterarSenhaUsuarioModel($vo);
    }
}
