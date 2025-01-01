<?php

namespace Src\Model;

use Src\Model\Conexao;
use Src\Model\SQL\SETOR_EQUIPAMENTO_SQL;
use Src\VO\SetorEquipamentoVO;

// Classe SetorEquipamentoModel que estende a classe Conexao
class SetorEquipamentoModel extends Conexao
{
    // Propriedade para armazenar a conexão com o banco de dados
    private $conn;

    // Construtor da classe
    public function __construct()
    {
        // Obtendo a conexão do pai (classe Conexao)
        $this->conn = parent::retornarConexao();
    }

    // Método para cadastrar um setor de equipamento
    public function CadastrarSetorEquipamentoModel(SetorEquipamentoVO $setorVO): int
    {
        // Preparando a consulta SQL usando a constante da classe SETOR_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(SETOR_EQUIPAMENTO_SQL::CADASTRAR_SETOR_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $setorVO->getNomeSetor());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao cadastrar
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $setorVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $setorVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $setorVO como argumento.
            parent::GravarLogErro($setorVO);

            return -1; // Falha ao cadastrar
        }
    }

    // Método para detalhar setor de equipamento
    public function DetalharSetorEquipamentoModel(): array
    {
        // Preparando a consulta SQL usando a constante da classe SETOR_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(SETOR_EQUIPAMENTO_SQL::DETALHAR_SETOR_EQUIPAMENTO());

        // Executando a consulta
        $conn->execute();

        // Retornando os resultados como um array associativo
        return $conn->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para alterar um Setor de equipamento
    public function AlterarSetorEquipamentoModel(SetorEquipamentoVO $setorVO): int
    {
        // Preparando a consulta SQL usando a constante da classe SETOR_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(Setor_EQUIPAMENTO_SQL::ALTERAR_SETOR_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $setorVO->getNomeSetor());
        $conn->bindValue(2, $setorVO->getIdSetor());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao alterar
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $setorVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $setorVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $setorVO como argumento.
            parent::GravarLogErro($setorVO);
            return -1; // Falha ao alterar
        }
    }


    // Método para excluir um Setor de equipamento
    public function DeletarSetorEquipamentoModel(SetorEquipamentoVO $setorVO): int
    {
        // Preparando a consulta SQL usando a constante da classe SETOR_EQUIAPMENTO_SQL
        $conn = $this->conn->prepare(SETOR_EQUIPAMENTO_SQL::EXCLUIR_SETOR_EQUIPAMENTO());

        // Ligando parâmetros
        $conn->bindValue(1, $setorVO->getIdSetor());

        // Tentando executar a consulta
        try {
            $conn->execute();
            return 1; // Sucesso ao excluir
        } catch (\Exception $ex) {
            // Define a mensagem de erro técnico no objeto $setorVO usando o método setErroTec,
            // atribuindo a mensagem da exceção ($ex->getMessage()).
            $setorVO->setErroTec($ex->getMessage());

            // Chama o método GravarLogErro da classe pai (parent) passando o objeto $setorVO como argumento.
            parent::GravarLogErro($setorVO);
            return -1; // Falha ao excluir
        }
    }
}
