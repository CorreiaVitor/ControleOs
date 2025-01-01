<?php

namespace Src\Controller;

// Importa a classe do modelo e o objeto de valor (VO) de Chamado
use Src\Model\ChamadoModel;
use Src\VO\ChamadoVO;

// Classe de controle para gerenciamento de chamados
class ChamadoCtrl
{
    // Propriedade para armazenar o modelo
    private $model;

    // Construtor para inicializar o modelo
    public function __construct()
    {
        $this->model = new ChamadoModel();
    }

    // Método para abrir um chamado
    public function AbrirChamadoCtrl(ChamadoVO $alocarVO): int
    {
       // Verifica se os campos obrigatórios estão preenchidos
       if(empty($alocarVO->getIdAlocar()) || empty($alocarVO->getProblema())){
           return 0; // Retorna erro se faltarem dados
       }

       // Define a situação como "equipamento em manutenção"
       $alocarVO->setSituacaoAlocar(SITUACAO_EQUIPAMENTO_MANUTENCAO);

       // Chama o método do modelo para abrir o chamado
       return $this->model->AbrirChamadoModel($alocarVO);
    }

    // Método para atender um chamado
    public function AtenderChamadoCtrl(ChamadoVO $chamadoVO): int
    {
       // Verifica se os campos obrigatórios estão preenchidos
       if(empty($chamadoVO->getIdTecAtendimento()) || empty($chamadoVO->getIdChamado())){
           return 0; // Retorna erro se faltarem dados
       }

       // Define a função de erro como "atender chamado"
       $chamadoVO->setFuncaoErro(ATENDER_CHAMADO);

       // Registra o técnico responsável no log
       $chamadoVO->setUserLog($chamadoVO->getIdTecAtendimento());

       // Chama o método do modelo para atender o chamado
       return $this->model->AtenderChamadoModel($chamadoVO);
    }

    // Método para finalizar um chamado
    public function FinalizarChamadoCtrl(ChamadoVO $chamadoVO): int
    {
       // Verifica se os campos obrigatórios estão preenchidos
       if(empty($chamadoVO->getIdTecFinalizar()) || empty($chamadoVO->getLaudo() || empty($chamadoVO->getIdAlocar()))){
           return 0; // Retorna erro se faltarem dados
       }

       // Define a situação como "chamado finalizado"
       $chamadoVO->setSituacaoAlocar(SITUACAO_CHAMADO_FINALIZADO);

       // Define a função de erro como "finalizar chamado"
       $chamadoVO->setFuncaoErro(FINALIZAR_CHAMADO);

       // Registra o técnico responsável no log
       $chamadoVO->setUserLog($chamadoVO->getIdTecFinalizar());

       // Chama o método do modelo para finalizar o chamado
       return $this->model->FinalizarChamadoModel($chamadoVO);
    }

    // Método para filtrar chamados
    public function FiltrarChamadoCtrl(int $situacao, int $setor_id = -1): array | null
    {
        // Chama o método do modelo para filtrar chamados com base nos critérios
        return $this->model->FiltrarChamadoModel($situacao, $setor_id);
    }
    
    // Método para detalhar um chamado específico
    public function DetalharChamadoCtrl(int $id): array | bool
    {
        // Chama o método do modelo para detalhar o chamado
        return $this->model->DetalharChamadoModel($id);
    }

    // Método para listar todos os dados de chamados
    public function MostrarDadosChamadoCtrl(): array
    {
        // Chama o método do modelo para obter todos os dados dos chamados
        return $this->model->MostrarDadosChamadoModel();
    }
}
