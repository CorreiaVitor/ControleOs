<?php

namespace Src\Model;

use Src\Model\Conexao;
use Src\Model\SQL\TIPO_EQUIPAMENTO_SQL;
use Src\VO\TipoEquipamentoVO;

// Classe TipoEquipamentoModel que estende a classe Conexao
class TipoEquipamentoModel extends Conexao
{
    // Propriedade para armazenar a conexão com o banco de dados
    private $conn;

    // Construtor da classe
    public function __construct()
    {
        // Obtendo a conexão do pai (classe Conexao)
        $this->conn = parent::retornarConexao();
    }

    // Método para cadastrar um tipo de equipamento
    public function CadastrarTipoEquipamentoModel(TipoEquipamentoVO $tipoVO): int
    {
        // Preparando a consulta SQL usando a constante da classe TIPO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(TIPO_EQUIPAMENTO_SQL::CADASTRAR_TIPO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $tipoVO->getNomeTipo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao cadastrar
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $tipoVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $tipoVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $tipoVO como argumento.
            parent::GravarLogErro($tipoVO);

            return -1; // Falha ao cadastrar
        }
    }

    // Método para detalhar tipos de equipamento
    public function DetalharTipoEquipamentoModel(): array
    {
        // Preparando a consulta SQL usando a constante da classe TIPO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(TIPO_EQUIPAMENTO_SQL::DETALHAR_TIPO_EQUIPAMENTO());

        // Executando a consulta
        $conn->execute();

        // Retornando os resultados como um array associativo
        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para alterar um tipo de equipamento
    public function AlterarTipoEquipamentoModel(TipoEquipamentoVO $tipoVO): int
    {
        // Preparando a consulta SQL usando a constante da classe TIPO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(TIPO_EQUIPAMENTO_SQL::ALTERAR_TIPO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $tipoVO->getNomeTipo());
        $conn->bindValue(2, $tipoVO->getIdTipo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao alterar
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $tipoVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $tipoVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $tipoVO como argumento.
            parent::GravarLogErro($tipoVO);
            return -1; // Falha ao alterar
        }
    }


    // Método para excluir um tipo de equipamento
    public function DeletarTipoEquipamentoModel(TipoEquipamentoVO $tipoVO): int
    {
        // Preparando a consulta SQL usando a constante da classe TIPO_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(TIPO_EQUIPAMENTO_SQL::EXCLUIR_TIPO_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $tipoVO->getIdTipo());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao excluir
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $tipoVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $tipoVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $tipoVO como argumento.
            parent::GravarLogErro($tipoVO);
            return -1; // Falha ao excluir
        }
    }
}
