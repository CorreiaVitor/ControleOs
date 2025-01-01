<?php

namespace Src\Resource\api\Classe;

use Src\Controller\ChamadoCtrl;
use Src\Controller\UsuarioCtrl;
use Src\Resource\api\Classe\ApiRequest;
use Src\VO\TecnicoVO;
use Src\VO\UsuarioVO;
use Src\VO\ChamadoVO;
use Src\public\Util;

class TecnicoEndPoints extends ApiRequest
{

    private $ctrl_user; // Controlador de usuário
    private $params; // Parâmetros da requisição

    // Construtor da classe, inicializa o controlador de usuários
    public function __construct()
    {
        $this->ctrl_user = new UsuarioCtrl();
    }

    // Adiciona parâmetros à classe
    public function AddParameters($p)
    {
        $this->params = $p;
    }

    // Verifica se o endpoint solicitado existe nesta classe
    public function CheckEndPoint($endpoint)
    {
        return method_exists($this, $endpoint);
    }

    // Valida o login do usuário através da API
    public function ValidarLoginApi()
    {
        return $this->ctrl_user->ValidarLoginApiCtrl(
            $this->params['login'],
            $this->params['senha']
        );
    }

    // Detalha os dados de um usuário específico
    public function DetalharUsuarioApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $dados_usuario = $this->ctrl_user->DetalharUsuarioCtrl($this->params['id_user']);
            return $dados_usuario;
        } else {
            return NAO_AUTORIZADO; // Código indicando falta de autorização
        }
    }

    // Altera os dados pessoais de um técnico
    public function AlterarMeusDadosApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $vo = new TecnicoVO; // Cria objeto VO (Value Object) para Técnico

            // Define dados específicos do técnico
            $vo->setNomeEmpresa($this->params['empresa']);
            $vo->setId($this->params['id_usuario']); // ID do usuário

            // Define dados gerais do usuário
            $vo->setNome($this->params['nome']);
            $vo->setTipoUsuario($this->params['tipo_usuario']);
            $vo->setEmail($this->params['email']);
            $vo->setCpf($this->params['cpf']);
            $vo->setTelefone($this->params['telefone']);

            // Define dados do endereço do usuário
            $vo->setEnderecoId($this->params['id_endereco']);
            $vo->setRua($this->params['rua']);
            $vo->setBairro($this->params['bairro']);
            $vo->setCep($this->params['cep']);
            $vo->setCidade($this->params['cidade']);
            $vo->setEstado($this->params['estado']);

            // Chama o método de alteração do controlador de usuário
            return $this->ctrl_user->AlterarUsuarioCtrl($vo, false);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Altera a senha do técnico
    public function AlterarSenhaUsuarioApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $vo = new UsuarioVO;

            $vo->setId($this->params['id_usuario']); // ID do usuário
            $vo->setSenha($this->params['nova_senha']); // Nova senha

            return $this->ctrl_user->AlterarSenhaUsuarioCtrl($vo, false);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Verifica se a senha fornecida está correta
    public function VerificarSenhaAPI()
    {
        if (Util::AuthenticationTokenAccess()) {
            return $this->ctrl_user->VerificarSenhaUsuarioCtrl($this->params['id_user'], $this->params['senha_digitada']);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Filtra os chamados com base em uma situação específica
    public function FiltrarChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            return (new ChamadoCtrl)->FiltrarChamadoCtrl(
                $this->params['situacao']
            );
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Detalha as informações de um chamado específico
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

    // Marca um chamado como em atendimento
    public function AtenderChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $chamadoVO = new ChamadoVO;

            // Define dados do chamado a ser atendido
            $chamadoVO->setIdTecAtendimento($this->params['id_tec']);
            $chamadoVO->setIdChamado($this->params['id_chamado']);

            return (new ChamadoCtrl)->AtenderChamadoCtrl($chamadoVO);
        } else {
            return NAO_AUTORIZADO;
        }
    }

    // Finaliza um chamado e adiciona um laudo
    public function FinalizarChamadoApi()
    {
        if (Util::AuthenticationTokenAccess()) {
            $chamadoVO = new ChamadoVO;

            // Define dados do chamado a ser finalizado
            $chamadoVO->setIdTecFinalizar($this->params['id_tec']);
            $chamadoVO->setIdChamado($this->params['id_chamado']);
            $chamadoVO->setIdAlocar($this->params['id_alocar']);
            $chamadoVO->setLaudo($this->params['laudo']); // Laudo final

            return (new ChamadoCtrl)->FinalizarChamadoCtrl($chamadoVO);
        } else {
            return NAO_AUTORIZADO;
        }
    }
}
