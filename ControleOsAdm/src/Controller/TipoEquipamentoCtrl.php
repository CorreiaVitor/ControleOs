<?php

namespace Src\Controller;

// Importa as classes necessárias
use Src\Model\TipoEquipamentoModel;
use Src\public\Util;
use Src\VO\TipoEquipamentoVO;

// Classe de controle para gerenciar os tipos de equipamentos
class TipoEquipamentoCtrl
{
    // Propriedade para armazenar o modelo
    private $model;

    // Construtor que inicializa o modelo
    public function __construct()
    {
        $this->model = new TipoEquipamentoModel();
    }

    // Método para cadastrar um tipo de equipamento
    public function CadastrarTipoEquipamentoCtrl(TipoEquipamentoVO $tipoVO): int
    {
        // Verifica se o nome do tipo está vazio
        if (empty($tipoVO->getNomeTipo())) {
            return 0; // Retorna erro se o nome estiver vazio
        }

        // Define o usuário atual no log
        $tipoVO->setUserLog(Util::UsuarioLog());

        // Define a função como "cadastrar tipo de equipamento"
        $tipoVO->setFuncaoErro(CADASTRAR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para cadastrar o tipo de equipamento
        return $this->model->CadastrarTipoEquipamentoModel($tipoVO);
    }

    // Método para alterar um tipo de equipamento
    public function AlterarTipoEquipamentoCtrl(TipoEquipamentoVO $tipoVO): int
    {
        // Verifica se o ID e o nome do tipo estão preenchidos
        if (empty($tipoVO->getIdTipo()) || empty($tipoVO->getNomeTipo())) {
            return 0; // Retorna erro se o ID ou o nome estiverem vazios
        }

        // Define o usuário atual no log
        $tipoVO->setUserLog(Util::UsuarioLog());

        // Define a função como "alterar tipo de equipamento"
        $tipoVO->setFuncaoErro(ALTERAR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para alterar o tipo de equipamento
        return $this->model->AlterarTipoEquipamentoModel($tipoVO);
    }

    // Método para detalhar os tipos de equipamentos
    public function DetalharTipoEquipamentoCtrl(): array
    {
        // Chama o método do modelo para obter detalhes dos tipos de equipamentos
        return $this->model->DetalharTipoEquipamentoModel();
    }

    // Método para excluir um tipo de equipamento
    public function DeletarTipoEquipamentoCtrl(TipoEquipamentoVO $tipoVO): int
    {
        // Verifica se o ID do tipo está preenchido
        if (empty($tipoVO->getIdTipo())) {
            return 0; // Retorna erro se o ID estiver vazio
        }

        // Define o usuário atual no log
        $tipoVO->setUserLog(Util::UsuarioLog());

        // Define a função como "excluir tipo de equipamento"
        $tipoVO->setFuncaoErro(EXCLUIR_TIPO_EQUIPAMENTO);

        // Chama o método do modelo para excluir o tipo de equipamento
        return $this->model->DeletarTipoEquipamentoModel($tipoVO);
    }
}
