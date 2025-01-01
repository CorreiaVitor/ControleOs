<?php

namespace Src\Model;

use Src\Model\SQL\EQUIPAMENTO_SQL;
use Src\VO\AlocarVO;
use Src\VO\EquipamentoVO;
use Src\VO\LogErroVO;

class EquipamentoModel extends Conexao
{
    private $conn;

    // Construtor que inicializa a conexão com o banco de dados usando a classe pai Conexao.
    public function __construct()
    {
        $this->conn = parent::retornarConexao();
    }

    // Método para cadastrar um equipamento, recebendo um objeto EquipamentoVO como parâmetro e retornando um inteiro.
    public function CadastrarEquipamentoModel(EquipamentoVO $equiVO): int
    {
        // Prepara a consulta SQL usando a classe EQUIPAMENTO_SQL.
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::CADASTRAR_EQUIPAMENTO_SQL());

        // Define os valores dos parâmetros na consulta SQL.
        $i = 1;
        $conn->bindValue($i++, $equiVO->getIdentificacao());
        $conn->bindValue($i++, $equiVO->getDescricao());
        $conn->bindValue($i++, $equiVO->getSituacao());
        $conn->bindValue($i++, $equiVO->getIdTipo());
        $conn->bindValue($i++, $equiVO->getIdModelo());

        try {
            // Executa a consulta SQL e retorna 1 se for bem-sucedida.
            $conn->execute();
            return 1;
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $equiVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $equiVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $equiVO como argumento.
            parent::GravarLogErro($equiVO);

            // Retorna -1 se ocorrer uma exceção durante a execução da consulta.
            return -1;
        }
    }

    // Método para alterar um equipamento, recebendo um objeto EquipamentoVO como parâmetro e retornando um inteiro.
    public function AlterarEquipamentoModel(EquipamentoVO $equiVO): int
    {
        // Prepara a consulta SQL usando a classe EQUIPAMENTO_SQL.
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::ALTERAR_EQUIPAMENTOS_SQL());

        // Define os valores dos parâmetros na consulta SQL.
        $i = 1;
        $conn->bindValue($i++, $equiVO->getIdentificacao());
        $conn->bindValue($i++, $equiVO->getDescricao());
        $conn->bindValue($i++, $equiVO->getIdTipo());
        $conn->bindValue($i++, $equiVO->getIdModelo());
        $conn->bindValue($i++, $equiVO->getIdEquipamento());

        try {
            // Executa a consulta SQL e retorna 1 se for bem-sucedida.
            $conn->execute();
            return 1;
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $equiVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $equiVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $equiVO como argumento.
            parent::GravarLogErro($equiVO);

            // Imprime a mensagem de exceção e retorna -1 se ocorrer uma exceção durante a execução da consulta.
            return -1;
        }
    }

    // Método para filtrar equipamentos, recebendo parâmetros e retornando um array.
    public function FiltrarEquipamentoModel(int $idTipo, int $idModelo, string $nome, int $situacao): array
    {
        // Prepara a consulta SQL usando a classe EQUIPAMENTO_SQL e define os valores dos parâmetros.
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::FILTRAR_EQUIPAMENTO_SQL($idTipo, $idModelo, $nome));

        $i = 1;
        $conn->bindValue($i++, $situacao);
        $conn->bindValue($i++, "$nome%");
        if ($idTipo != 0 && $idModelo != 0) {
            $conn->bindValue($i++, $idTipo);
            $conn->bindValue($i++, $idModelo);
        } else if ($idTipo == 0 && $idModelo != 0) {
            $conn->bindValue($i++, $idModelo);
        } else if ($idModelo == 0 && $idTipo != 0) {
            $conn->bindValue($i++, $idTipo);
        }

        // Executa a consulta SQL e retorna o resultado como um array associativo.
        $conn->execute();
        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para detalhar um equipamento, recebendo o Id do equipamento como parâmetro e retornando um array associativo.
    public function DetalharEquipamentoModel(int | string $id_equipamento): array | bool
    {
        // Prepara a consulta SQL usando a classe EQUIPAMENTO_SQL e define o valor do parâmetro.
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::DETALHAR_EQUIPAMENTO_SQL());

        $conn->bindValue(1, $id_equipamento);

        // Executa a consulta SQL e retorna o resultado como um array associativo.
        $conn->execute();
        return $conn->fetch(\PDO::FETCH_ASSOC);
    }

    // Método para descartar um equipamento, recebendo um objeto EquipamentoVO como parâmetro e retornando um inteiro.
    public function DescatarEquipamentoModel(EquipamentoVO $equiVO): int
    {
        // Prepara a consulta SQL usando a classe EQUIPAMENTO_SQL.
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::DESCARTA_EQUIPAMENTO_SQL());

        // Define os valores dos parâmetros na consulta SQL.
        $i = 1;
        $conn->bindValue($i++, $equiVO->getSituacao());
        $conn->bindValue($i++, $equiVO->getDataDescarte());
        $conn->bindValue($i++, $equiVO->getMotivoDescarte());
        $conn->bindValue($i++, $equiVO->getIdEquipamento());

        try {
            // Executa a consulta SQL e retorna 1 se for bem-sucedida.
            $conn->execute();
            return 1;
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $equiVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $equiVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $equiVO como argumento.
            parent::GravarLogErro($equiVO);

            // Imprime a mensagem de exceção e retorna -1 se ocorrer uma exceção durante a execução da consulta.
            return -1;
        }
    }

    public function ConsultarEquipamentoNaoAlocadoModel($situacao, $situacao_alocar): array
    {
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::CONSULTAR_EQUIPAMENTO_NAO_ALOCADO_SQL());

        $i = 1;
        $conn->bindValue($i++, $situacao);
        $conn->bindValue($i++, $situacao_alocar);

        $conn->execute();

        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function AlocarEquipamentoModel(AlocarVO $alocarVO): int
    {
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::ALOCAR_EQUIPAMENTO_SQL());

        $i = 1;
        $conn->bindValue($i++, $alocarVO->getDataAlocar());
        $conn->bindValue($i++, $alocarVO->getSituacao());
        $conn->bindValue($i++, $alocarVO->getEquipamentoId());
        $conn->bindValue($i++, $alocarVO->getSetorId());

        try {
            $conn->execute();
            return 1;
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $alocarVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $alocarVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $alocarVO como argumento.
            parent::GravarLogErro($alocarVO);

            // Imprime a mensagem de exceção e retorna -1 se ocorrer uma exceção durante a execução da consulta.
            return -1;
        }
    }

    public function EquipamentoAlocadoSetorModel(int $situacao, $id_setor): array | null
    {
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::EQUIPAMENTO_ALOCADO_SETOR());

        $i = 1;
        $conn->bindValue($i++, $id_setor);
        $conn->bindValue($i++, $situacao);

        $conn->execute();

        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function RemoverEquipamentoAlocadoModel(AlocarVO $alocarVO): int
    {
        
        $conn = $this->conn->prepare(EQUIPAMENTO_SQL::REMOVER_EQUIPAMENTO_ALOCADO());

        $conn->bindValue(1, $alocarVO->getSituacao());
        $conn->bindValue(2, $alocarVO->getDataAlocar());
        $conn->bindValue(3, $alocarVO->getId());

        try {
            $conn->execute();
            return 1;
        } catch (\Exception $ex) {
            $alocarVO->setErroTec($ex->getMessage());
            parent::GravarLogErro($alocarVO);
            return -1;
        }
    }
}
