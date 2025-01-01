<?php

namespace Src\Controller;

// Importa as classes necessárias
use Src\Model\SetorEquipamentoModel;
use Src\public\Util;
use Src\VO\SetorEquipamentoVO;

// Classe de controle para gerenciar os setores de equipamentos
class SetorEquipamentoCtrl
{
    // Propriedade para armazenar o modelo
    private $model;

    // Construtor que inicializa o modelo
    public function __construct()
    {
        $this->model = new SetorEquipamentoModel();
    }

    // Método para cadastrar um setor de equipamento
    public function CadastrarSetorEquipamentoCtrl(SetorEquipamentoVO $setorVO): int
    {
        // Verifica se o nome do setor está vazio
        if (empty($setorVO->getNomeSetor())) {
            return 0; // Retorna erro se o nome estiver vazio
        }

        // Define o usuário atual no log
        $setorVO->setUserLog(Util::UsuarioLog());

        // Define a função como "cadastrar setor de equipamento"
        $setorVO->setFuncaoErro(CADASTRAR_SETOR_EQUIPAMENTO);

        // Chama o método do modelo para cadastrar o setor de equipamento
        return $this->model->CadastrarSetorEquipamentoModel($setorVO);
    }

    // Método para alterar um setor de equipamento
    public function AlterarSetorEquipamentoCtrl(SetorEquipamentoVO $setorVO): int
    {
        // Verifica se o ID e o nome do setor estão preenchidos
        if (empty($setorVO->getIdSetor()) || empty($setorVO->getNomeSetor())) {
            return 0; // Retorna erro se o ID ou o nome estiverem vazios
        }

        // Define o usuário atual no log
        $setorVO->setUserLog(Util::UsuarioLog());

        // Define a função como "alterar setor de equipamento"
        $setorVO->setFuncaoErro(ALTERAR_SETOR_EQUIPAMENTO);

        // Chama o método do modelo para alterar o setor de equipamento
        return $this->model->AlterarSetorEquipamentoModel($setorVO);
    }

    // Método para detalhar setores de equipamento
    public function DetalharSetorEquipamentoCtrl(): array
    {
        // Chama o método do modelo para obter detalhes dos setores de equipamento
        return $this->model->DetalharSetorEquipamentoModel();
    }

    // Método para excluir um setor de equipamento
    public function DeletarSetorEquipamentoCtrl(SetorEquipamentoVO $setorVO): int
    {
        // Verifica se o ID do setor está preenchido
        if (empty($setorVO->getIdSetor())) {
            return 0; // Retorna erro se o ID estiver vazio
        }

        // Define o usuário atual no log
        $setorVO->setUserLog(Util::UsuarioLog());

        // Define a função como "excluir setor de equipamento"
        $setorVO->setFuncaoErro(EXCLUIR_SETOR_EQUIPAMENTO);

        // Chama o método do modelo para excluir o setor de equipamento
        return $this->model->DeletarSetorEquipamentoModel($setorVO);
    }
}
