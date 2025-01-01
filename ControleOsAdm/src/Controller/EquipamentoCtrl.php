<?php

namespace Src\Controller;

// Importa classes e utilitários necessários
use Src\Model\EquipamentoModel;
use Src\public\Util;
use Src\VO\AlocarVO;
use Src\VO\EquipamentoVO;

// Classe de controle para gerenciamento de equipamentos
class EquipamentoCtrl
{
    // Propriedade para armazenar o modelo de Equipamento
    private $model;

    // Construtor que inicializa o modelo
    public function __construct()
    {
        $this->model = new EquipamentoModel();
    }

    // Método para cadastrar um equipamento
    public function CadastrarEquipamentoCtrl(EquipamentoVO $equiVO): int
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (empty($equiVO->getIdentificacao()) || empty($equiVO->getDescricao()) || empty($equiVO->getIdTipo()) || empty($equiVO->getIdModelo())) {
            return 0; // Retorna erro se algum campo obrigatório estiver vazio
        }

        // Define a situação do equipamento como "ativo"
        $equiVO->setSituacao(SITUACAO_ATIVO);

        // Define o usuário atual no log
        $equiVO->setUserLog(Util::UsuarioLog());

        // Define a função como "cadastrar equipamento"
        $equiVO->setFuncaoErro(CADASTRAR_EQUIPAMENTO);

        // Chama o método do modelo para cadastrar o equipamento
        return $this->model->CadastrarEquipamentoModel($equiVO);
    }

    // Método para alterar um equipamento
    public function AlterarEquipamentoCtrl(EquipamentoVO $equiVO): int
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (empty($equiVO->getIdentificacao()) || empty($equiVO->getDescricao()) || empty($equiVO->getIdTipo()) || empty($equiVO->getIdModelo())) {
            return 0; // Retorna erro se algum campo obrigatório estiver vazio
        }

        // Define o usuário atual no log
        $equiVO->setUserLog(Util::UsuarioLog());

        // Define a função como "alterar equipamento"
        $equiVO->setFuncaoErro(ALTERAR_EQUIPAMENTO);

        // Chama o método do modelo para alterar o equipamento
        return $this->model->AlterarEquipamentoModel($equiVO);
    }

    // Método para filtrar equipamentos
    public function FiltrarEquipamentoCtrl(int $idTipo, int $idModelo, string $nome): array
    {
        // Chama o método do modelo para filtrar equipamentos com os critérios fornecidos
        return $this->model->FiltrarEquipamentoModel($idTipo, $idModelo, $nome, SITUACAO_EQUIPAMENTO_DESCARTADO);
    }

    // Método para detalhar um equipamento específico
    public function DetalharEquipamentoCtrl(int | string $id_equipamento): array | bool
    {
        // Chama o método do modelo para obter os detalhes do equipamento
        return $this->model->DetalharEquipamentoModel($id_equipamento);
    }

    // Método para descartar um equipamento
    public function DescartarEquipamentoCtrl(EquipamentoVO $equiVO): int
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (empty($equiVO->getDataDescarte()) || empty($equiVO->getMotivoDescarte())) {
            return 0; // Retorna erro se algum campo obrigatório estiver vazio
        }

        // Define a situação como "descartado"
        $equiVO->setSituacao(SITUACAO_DESCARTADO);

        // Define o usuário atual no log
        $equiVO->setUserLog(Util::UsuarioLog());

        // Define a função como "descartar equipamento"
        $equiVO->setFuncaoErro(DESCARTAR_EQUIPAMENTO);

        // Chama o método do modelo para descartar o equipamento
        return $this->model->DescatarEquipamentoModel($equiVO);
    }

    // Método para consultar equipamentos não alocados
    public function ConsultarEquipamentoNaoAlocadoCtrl(): array
    {
        // Chama o método do modelo para listar equipamentos não alocados
        return $this->model->ConsultarEquipamentoNaoAlocadoModel(SITUACAO_EQUIPAMENTO_ALOCADO, SITUACAO_EQUIPAMENTO_DESCARTADO);
    }

    // Método para alocar um equipamento
    public function AlocarEquipamentoCtrl(AlocarVO $alocarVO)
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (empty($alocarVO->getEquipamentoId()) || empty($alocarVO->getSetorId())) {
            return 0; // Retorna erro se algum campo obrigatório estiver vazio
        }

        // Define o usuário atual no log
        $alocarVO->setUserLog(Util::UsuarioLog());

        // Define a função como "alocar equipamento"
        $alocarVO->setFuncaoErro(ALOCAR_EQUIPAMENTO);

        // Define a situação como "alocado"
        $alocarVO->setSituacao(SITUACAO_EQUIPAMENTO_ALOCADO);

        // Chama o método do modelo para alocar o equipamento
        return $this->model->AlocarEquipamentoModel($alocarVO);
    }

    // Método para listar equipamentos alocados a um setor específico
    public function EquipamentoAlocadoSetorCtrl($id_setor): array | null
    {
        // Chama o método do modelo para listar os equipamentos alocados no setor
        return $this->model->EquipamentoAlocadoSetorModel(SITUACAO_EQUIPAMENTO_ALOCADO, $id_setor);
    }

    // Método para remover um equipamento alocado
    public function RemoverEquipamentoAlocadoCtrl(AlocarVO $alocarVO)
    {
        // Define a situação como "descartado"
        $alocarVO->setSituacao(SITUACAO_EQUIPAMENTO_DESCARTADO);

        // Define a função como "alocar equipamento"
        $alocarVO->setFuncaoErro(ALOCAR_EQUIPAMENTO);

        // Chama o método do modelo para remover o equipamento alocado
        return $this->model->RemoverEquipamentoAlocadoModel($alocarVO);
    }
}
