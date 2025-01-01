<?php

namespace Src\Model;

use Src\Model\Conexao;
use Src\Model\SQL\MODELO_EQUIPAMENTO_SQL;
use Src\VO\ModeloEquipamentoVO;

// Classe modeloEquipamentoModel que estende a classe Conexao
class ModeloEquipamentoModel extends Conexao
{
    // Propriedade para armazenar a conexão com o banco de dados
    private $conn;

    // Construtor da classe
    public function __construct()
    {
        // Obtendo a conexão do pai (classe Conexao)
        $this->conn = parent::retornarConexao();
    }

    // Método para cadastrar um modelo de equipamento
    public function CadastrarModeloEquipamentoModel(ModeloEquipamentoVO $modeloVO): int
    {
        // Preparando a consulta SQL usando a constante da classe modelo_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(MODELO_EQUIPAMENTO_SQL::CADASTRAR_MODELO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $modeloVO->getNomeModelo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao cadastrar
        } catch (\Exception $ex) {

            // Define a mensagem de erro técnico no objeto $modeloVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $modeloVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $modeloVO como argumento.
            parent::GravarLogErro($modeloVO);


            return -1; // Falha ao cadastrar
        }
    }

    // Método para detalhar modelos de equipamento
    public function DetalharModeloEquipamentoModel(): array
    {
        // Preparando a consulta SQL usando a constante da classe MODELO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(MODELO_EQUIPAMENTO_SQL::DETALHAR_MODELO_EQUIPAMENTO());

        // Executando a consulta
        $conn->execute();

        // Retornando os resultados como um array associativo
        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para alterar um modelo de equipamento
    public function AlterarModeloEquipamentoModel(ModeloEquipamentoVO $modeloVO): int
    {
        // Preparando a consulta SQL usando a constante da classe MODELO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(MODELO_EQUIPAMENTO_SQL::ALTERAR_MODELO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $modeloVO->getNomeModelo());
        $conn->bindValue(2, $modeloVO->getIdModelo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao alterar
        } catch (\Exception $ex) {

            // Define a mensagem de erro técnico no objeto $modeloVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $modeloVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $modeloVO como argumento.
            parent::GravarLogErro($modeloVO);


            return -1; // Falha ao alterar
        }
    }


    // Método para excluir um modelo de equipamento
    public function DeletarModeloEquipamentoModel(ModeloEquipamentoVO $modeloVO): int
    {
        // Preparando a consulta SQL usando a constante da classe MODELO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(MODELO_EQUIPAMENTO_SQL::EXCLUIR_MODELO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $modeloVO->getIdModelo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao excluir
        } catch (\Exception $ex) {

            // Define a mensagem de erro técnico no objeto $modeloVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $modeloVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $modeloVO como argumento.
            parent::GravarLogErro($modeloVO);


            return -1; // Falha ao excluir
        }
    }
}
