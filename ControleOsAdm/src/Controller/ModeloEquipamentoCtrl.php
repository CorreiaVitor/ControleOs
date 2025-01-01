<?php

namespace Src\Controller;

// Importa classes necessárias
use Src\Model\ModeloEquipamentoModel;
use Src\public\Util;
use Src\VO\ModeloEquipamentoVO;

// Classe de controle para gerenciar os modelos de equipamento
class ModeloEquipamentoCtrl
{
    // Propriedade para armazenar o modelo
    private $model;

    // Construtor que inicializa o modelo
    public function __construct()
    {
        $this->model = new ModeloEquipamentoModel();
    }

    // Método para cadastrar um modelo de equipamento
    public function CadastrarModeloEquipamentoCtrl(ModeloEquipamentoVO $modeloVO): int
    {
        // Verifica se o nome do modelo está vazio
        if (empty($modeloVO->getNomeModelo())) {
            return 0; // Retorna erro se o nome estiver vazio
        }

        // Define o usuário atual no log
        $modeloVO->setUserLog(Util::UsuarioLog());

        // Define a função como "cadastrar tipo de equipamento"
        $modeloVO->setFuncaoErro(CADASTRAR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para cadastrar o modelo de equipamento
        return $this->model->CadastrarModeloEquipamentoModel($modeloVO);
    }

    // Método para alterar um modelo de equipamento
    public function AlterarModeloEquipamentoCtrl(ModeloEquipamentoVO $modeloVO): int
    {
        // Verifica se o ID e o nome do modelo estão preenchidos
        if (empty($modeloVO->getIdModelo()) || empty($modeloVO->getNomeModelo())) {
            return 0; // Retorna erro se o ID ou o nome estiverem vazios
        }

        // Define o usuário atual no log
        $modeloVO->setUserLog(Util::UsuarioLog());

        // Define a função como "alterar tipo de equipamento"
        $modeloVO->setFuncaoErro(ALTERAR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para alterar o modelo de equipamento
        return $this->model->AlterarModeloEquipamentoModel($modeloVO);
    }

    // Método para detalhar modelos de equipamento
    public function DetalharModeloEquipamentoCtrl(): array
    {
        // Chama o método do modelo para obter detalhes dos modelos de equipamento
        return $this->model->DetalharModeloEquipamentoModel();
    }

    // Método para excluir um modelo de equipamento
    public function DeletarModeloEquipamentoCtrl(ModeloEquipamentoVO $modeloVO): int
    {
        // Verifica se o ID do modelo está preenchido
        if (empty($modeloVO->getIdModelo())) {
            return 0; // Retorna erro se o ID estiver vazio
        }

        // Define o usuário atual no log
        $modeloVO->setUserLog(Util::UsuarioLog());

        // Define a função como "excluir tipo de equipamento"
        $modeloVO->setFuncaoErro(EXCLUIR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para excluir o modelo de equipamento
        return $this->model->DeletarModeloEquipamentoModel($modeloVO);
    }
}
