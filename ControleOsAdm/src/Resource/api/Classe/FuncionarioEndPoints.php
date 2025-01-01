<?php

namespace Src\Resource\api\Classe;

use Src\Controller\ChamadoCtrl;
use Src\Controller\UsuarioCtrl;
use Src\Resource\api\Classe\ApiRequest;
use Src\VO\FuncionarioVO;
use Src\VO\UsuarioVO;
use Src\VO\ChamadoVO;
use Src\Controller\EquipamentoCTRL;
use Src\public\Util;

class FuncionarioEndPoints extends ApiRequest
{

    private $ctrl_user; // Controlador de usuário
    private $params;    // Parâmetros recebidos da requisição

    public function __construct()
    {
        $this->ctrl_user = new UsuarioCtrl(); // Inicializa o controlador de usuários
    }

    // Adiciona parâmetros à requisição
    public function AddParameters($p)
    {
        $this->params = $p;
    }

    // Verifica se o endpoint solicitado existe nesta classe
    public function CheckEndPoint($endpoint)
    {
        return method_exists($this, $endpoint);
    }

    // Valida o login do usuário
    public function ValidarLoginApi()
    {
        return $this->ctrl_user->ValidarLoginApiCtrl(
            $this->params['login'],
            $this->params['senha']
        );
    }

    // Detalha informações de um usuário
    public function DetalharUsuarioApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $dados_usuario = $this->ctrl_user->DetalharUsuarioCtrl($this->params['id_user']);

            return $dados_usuario;
        } else {
            return NAO_AUTORIZADO; // Retorna "não autorizado" se token for inválido
        }
    }

    // Altera os dados do usuário logado
    public function AlterarMeusDadosApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            // Cria objeto FuncionarioVO para armazenar as propriedades únicas do funcionário
            $vo = new FuncionarioVO;
            $vo->setIdsetor($this->params['setor']);

            // Define dados do usuário
            $vo->setId($this->params['id_usuario']);
            $vo->setNome($this->params['nome']);
            $vo->setTipoUsuario($this->params['tipo_usuario']);
            $vo->setEmail($this->params['email']);
            $vo->setCpf($this->params['cpf']);
            $vo->setTelefone($this->params['telefone']);

            // Define dados do endereço
            $vo->setEnderecoId($this->params['id_endereco']);
            $vo->setRua($this->params['rua']);
            $vo->setBairro($this->params['bairro']);
            $vo->setCep($this->params['cep']);
            $vo->setCidade($this->params['cidade']);
            $vo->setEstado($this->params['estado']);

            return $this->ctrl_user->AlterarUsuarioCtrl($vo, false);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Altera a senha do usuário logado
    public function AlterarSenhaUsuarioApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $vo = new UsuarioVO;

            $vo->setId($this->params['id_usuario']);
            $vo->setSenha($this->params['nova_senha']);

            return $this->ctrl_user->AlterarSenhaUsuarioCtrl($vo, false);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Verifica se a senha fornecida é válida
    public function VerificarSenhaAPI()
    {
        if (Util::AuthenticationTokenAccess()) {
            return $this->ctrl_user->VerificarSenhaUsuarioCtrl($this->params['id_user'], $this->params['senha_digitada']);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Lista equipamentos alocados para um setor
    public function EquipamentosAlocadosSetorApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            return (new EquipamentoCTRL)->EquipamentoAlocadoSetorCTRL($this->params['id_setor']);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Abre um chamado
    public function AbrirChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $vo = new ChamadoVO;

            $vo->setIdAlocar($this->params['id_alocar']);
            $vo->setIdFuncionario($this->params['funcionario_id']);
            $vo->setProblema($this->params['problema']);

            return (new ChamadoCtrl)->AbrirChamadoCtrl($vo);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Filtra chamados com base na situação e setor
    public function FiltrarChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            return (new ChamadoCtrl)->FiltrarChamadoCtrl(
                $this->params['situacao'],
                $this->params['id_setor']
            );
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Detalha um chamado específico
    public function DetalharChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            return (new ChamadoCtrl)->DetalharChamadoCtrl(
                $this->params['id']
            );
        } else {
            return NAO_AUTORIZADO;
        }
    }
}
