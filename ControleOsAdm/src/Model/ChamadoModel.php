<?php

namespace Src\Model;

use Src\Model\SQL\CHAMADO_SQL;
use Src\VO\ChamadoVO;

class ChamadoModel extends Conexao
{

    private $conn;

    // Construtor: Estabelece a conexão com o banco de dados.
    public function __construct()
    {
        return $this->conn = parent::retornarConexao();
    }

    // Função para abrir um chamado. Realiza a inserção dos dados do chamado e atualiza a alocação.
    public function AbrirChamadoModel(ChamadoVO $vo) : int
    {
        // Prepara a consulta SQL para abrir o chamado
        $conn = $this->conn->prepare(CHAMADO_SQL::ABRIR_CHAMADO_SQL());

        $i = 1;
        // Vincula os valores aos parâmetros da consulta SQL
        $conn->bindValue($i++, $vo->getDataAbertura());
        $conn->bindValue($i++, $vo->getHoraAbertura());
        $conn->bindValue($i++, $vo->getProblema());
        $conn->bindValue($i++, $vo->getIdFuncionario());
        $conn->bindValue($i++, $vo->getIdAlocar());

        // Inicia uma transação para garantir a atomicidade das operações
        $this->conn->beginTransaction();

        try {
            // Executa a consulta para abrir o chamado
            $conn->execute();

            // Prepara a consulta para atualizar a alocação
            $conn = $this->conn->prepare(CHAMADO_SQL::ATUALIZAR_ALOCAMENTO_SQL());

            $i = 1;
            // Vincula os valores da alocação
            $conn->bindValue($i++, $vo->getSituacaoAlocar());
            $conn->bindValue($i++, $vo->getIdAlocar());

            // Executa a atualização da alocação
            $conn->execute();

            // Confirma a transação
            $this->conn->commit();

            return 1; // Sucesso
        } catch (\Exception $ex) {
            // Caso ocorra um erro, reverte a transação
            echo $ex->getMessage();
            $this->conn->rollBack();
            return -1; // Falha
        }
    }

    // Função para atender um chamado, registrando a data e hora do atendimento.
    public function AtenderChamadoModel(ChamadoVO $vo) : int
    {
        // Prepara a consulta SQL para atender o chamado
        $conn = $this->conn->prepare(CHAMADO_SQL::ATENDER_CHAMADO_SQL());

        $i = 1;
        // Vincula os parâmetros de data, hora e técnico do atendimento
        $conn->bindValue($i++, $vo->getDataAtendimento());
        $conn->bindValue($i++, $vo->getHoraAtendimento());
        $conn->bindValue($i++, $vo->getIdTecAtendimento());
        $conn->bindValue($i++, $vo->getIdChamado());

        try {
            // Executa a consulta de atendimento
            $conn->execute();
            return 1; // Sucesso
        } catch (\Exception $ex) {
            // Em caso de erro, retorna falha
            echo $ex->getMessage();
            return -1; // Falha
        }
    }

    // Função para finalizar um chamado, registrando o laudo e atualizando a alocação.
    public function FinalizarChamadoModel(ChamadoVO $vo) : int
    {
        // Prepara a consulta SQL para finalizar o chamado
        $conn = $this->conn->prepare(CHAMADO_SQL::FINALIZAR_CHAMADO_SQL());

        $i = 1;
        // Vincula os parâmetros do laudo e técnico responsável pela finalização
        $conn->bindValue($i++, $vo->getDataEncerramento());
        $conn->bindValue($i++, $vo->getHoraEncerramento());
        $conn->bindValue($i++, $vo->getLaudo());
        $conn->bindValue($i++, $vo->getIdTecFinalizar());
        $conn->bindValue($i++, $vo->getIdChamado());
        
        // Inicia uma transação
        $this->conn->beginTransaction();

        try {
            // Executa a consulta para finalizar o chamado
            $conn->execute();

            // Prepara a consulta para atualizar a alocação
            $conn = $this->conn->prepare(CHAMADO_SQL::ATUALIZAR_ALOCAMENTO_SQL());

            $i = 1;
            // Vincula os dados de situação da alocação
            $conn->bindValue($i++, $vo->getSituacaoAlocar());
            $conn->bindValue($i++, $vo->getIdAlocar());

            // Executa a atualização
            $conn->execute();

            // Confirma a transação
            $this->conn->commit();

            return 1; // Sucesso
        } catch (\Exception $ex) {
            // Reverte a transação em caso de erro
            echo $ex->getMessage();
            $this->conn->rollBack();
            return -1; // Falha
        }
    }

    // Função para filtrar chamados com base na situação e no setor, caso fornecido.
    public function FiltrarChamadoModel(int $situacao, int $setor_id): array | null
    {
        // Verifica se o setor foi especificado
        $tem_setor = $setor_id == -1 ? false : true;

        // Prepara a consulta para filtrar os chamados com base na situação e setor
        $sql = $this->conn->prepare(CHAMADO_SQL::FILTRAR_CHAMADO($situacao, $tem_setor));

        $i = 1;
        // Se o setor for especificado, vincula o valor
        if ($tem_setor) {
            $sql->bindValue($i++, $setor_id);
        }

        // Executa a consulta
        $sql->execute();
        // Retorna os resultados da consulta
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Função para detalhar um chamado específico, fornecendo informações detalhadas.
    public function DetalharChamadoModel(int $id): array | bool
    {
        // Prepara a consulta para obter os detalhes do chamado
        $sql = $this->conn->prepare(CHAMADO_SQL::DETALHAR_CHAMADO_SQL());

        // Vincula o ID do chamado
        $sql->bindValue(1, $id);

        // Executa a consulta
        $sql->execute();
        // Retorna os detalhes ou falso se não encontrado
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    // Função para mostrar dados resumidos sobre os chamados atuais.
    public function MostrarDadosChamadoModel(): array
    {
        // Prepara a consulta para obter dados de números de chamados atuais
        $sql = $this->conn->prepare(CHAMADO_SQL::NUMEROS_CHAMADOS_ATUAL());

        // Executa a consulta
        $sql->execute();
        // Retorna os resultados da consulta
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
}
