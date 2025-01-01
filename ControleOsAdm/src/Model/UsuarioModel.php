<?php

namespace Src\Model;

use Src\Model\SQL\USUARIO_SQL;
use Src\Model\Conexao;
use Src\VO\UsuarioVO;

class UsuarioModel extends Conexao
{
    private $conn;

    // Construtor da classe, obtém a conexão com o banco de dados
    public function __construct()
    {
        $this->conn = parent::retornarConexao(); // Chama o método da classe pai para obter a conexão
    }

    // Verifica se o e-mail informado já está cadastrado no banco
    public function VerificarEmailCadastradoModel($email_usuario): bool
    {
        $conn = $this->conn->prepare(USUARIO_SQL::VERIFICAR_EMAIL_CADASTRADO());

        $conn->bindValue(1, $email_usuario); // Vincula o e-mail ao parâmetro na consulta SQL

        $conn->execute();

        $ver_email = $conn->fetchAll(\PDO::FETCH_ASSOC); // Obtém o resultado da consulta
        return $ver_email[0]['contar_email_usuario'] == 0 ? false : true; // Retorna true se o e-mail estiver cadastrado, caso contrário, false
    }

    // Valida o login do usuário, verificando o status e o login
    public function ValidarLoginModel(string $login, int $status): array | null | bool
    {
        $conn = $this->conn->prepare(USUARIO_SQL::VALIDAR_LOGIN_SQL());

        $conn->bindValue(1, $login);
        $conn->bindValue(2, $status);

        $conn->execute();

        return $conn->fetch(\PDO::FETCH_ASSOC); // Retorna os dados do usuário caso o login seja válido
    }

    // Cadastra um novo usuário no sistema
    public function CadastrarUsuarioModel($useVO): int
    {
        $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_USUARIO_SQL());

        $i = 1;
        // Vincula os dados do usuário no SQL
        $conn->bindValue($i++, $useVO->getNome());
        $conn->bindValue($i++, $useVO->getTipo());
        $conn->bindValue($i++, $useVO->getEmail());
        $conn->bindValue($i++, $useVO->getCpf());
        $conn->bindValue($i++, $useVO->getSenha());
        $conn->bindValue($i++, $useVO->getStatus());
        $conn->bindValue($i++, $useVO->getTelefone());

        try {
            $this->conn->beginTransaction(); // Inicia uma transação para garantir que todas as operações aconteçam juntas

            // Executa a inserção na tabela de usuários
            $conn->execute();

            // Recupera o ID do usuário cadastrado
            $id_user = $this->conn->lastInsertId();

            // Dependendo do tipo de usuário, insere dados adicionais nas tabelas específicas (Técnico ou Funcionário)
            switch ($useVO->getTipo()) {
                case USUARIO_TECNICO:
                    $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_USUARIO_TECNICO_SQL());
                    $i = 1;
                    $conn->bindValue($i++, $id_user);
                    $conn->bindValue($i++, $useVO->getNomeEmpresa());
                    $conn->execute();
                    break;
                case USUARIO_FUNCIONARIO:
                    $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_USUARIO_FUNCIONARIO_SQL());
                    $i = 1;
                    $conn->bindValue($i++, $id_user);
                    $conn->bindValue($i++, $useVO->getIdSetor());
                    $conn->execute();
                    break;
            }

            // Processo de cadastro de endereço
            // Verifica se a cidade já existe no banco
            $conn = $this->conn->prepare(USUARIO_SQL::VERIFICAR_CIDADE_CADASTRADA_SQL());
            $i = 1;
            $conn->bindValue($i++, $useVO->getCidade());
            $conn->bindValue($i++, $useVO->getEstado());
            $conn->execute();
            $tem_cidade = $conn->fetchAll(\PDO::FETCH_ASSOC);

            // Se a cidade não existir, cria o estado e a cidade
            $id_cidade = 0;
            if (count($tem_cidade) > 0) {
                $id_cidade = $tem_cidade[0]['id_cidade'];
            } else {
                // Verifica se o estado já existe
                $conn = $this->conn->prepare(USUARIO_SQL::VERIFICAR_ESTADO_CADASTRADA_SQL());
                $conn->bindValue(1, $useVO->getEstado());
                $conn->execute();
                $tem_estado = $conn->fetchAll(\PDO::FETCH_ASSOC);

                if (count($tem_estado) > 0) {
                    $id_estado = $tem_estado[0]['id_estado'];
                } else {
                    // Caso o estado não exista, cria o estado
                    $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_ESTADO_SQL());
                    $conn->bindValue(1, $useVO->getEstado());
                    $conn->execute();
                    $id_estado = $this->conn->lastInsertId();
                }

                // Cria a cidade no banco
                $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_CIDADE_SQL());
                $i = 1;
                $conn->bindValue($i++, $useVO->getCidade());
                $conn->bindValue($i++, $id_estado);
                $conn->execute();

                $id_cidade = $this->conn->lastInsertId();
            }

            // Insere o endereço do usuário
            $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_ENDERECO_SQL());
            $i = 1;
            $conn->bindValue($i++, $useVO->getRua());
            $conn->bindValue($i++, $useVO->getBairro());
            $conn->bindValue($i++, $useVO->getCep());
            $conn->bindValue($i++, $id_user);
            $conn->bindValue($i++, $id_cidade);
            $conn->execute();

            $this->conn->commit(); // Commit para finalizar a transação

            return 1; // Retorna 1 indicando sucesso
        } catch (\Exception $ex) {
            $this->conn->rollBack(); // Caso ocorra erro, desfaz a transação
            $useVO->setErroTec($ex->getMessage());
            parent::GravarLogErro($useVO); // Registra o erro
            return 1; // Retorna 1 mesmo em caso de erro, talvez indicando que algo deu errado no processo
        }
    }

    // Método para alterar dados do usuário
    public function AlterarUsuarioModel($useVO): int
    {
        // Lógica semelhante ao método de cadastrar, mas para atualizar os dados no banco de dados
        // Implementação parecida para alterar dados do usuário, técnico e funcionário, e também o endereço
        $conn = $this->conn->prepare(USUARIO_SQL::ALTERAR_USUARIO_SQL());

        $i = 1;
        // Atualiza os valores do usuário
        $conn->bindValue($i++, $useVO->getNome());
        $conn->bindValue($i++, $useVO->getEmail());
        $conn->bindValue($i++, $useVO->getCpf());
        $conn->bindValue($i++, $useVO->getSenha());
        $conn->bindValue($i++, $useVO->getTelefone());
        $conn->bindValue($i++, $useVO->getId());

        try {
            // Inicia uma transação
            $this->conn->beginTransaction();
            // Executa a alteração do usuário
            $conn->execute();

            // Dependendo do tipo de usuário, altera informações adicionais
            switch ($useVO->getTipo()) {
                case USUARIO_TECNICO:
                    $conn = $this->conn->prepare(USUARIO_SQL::ALTERAR_USUARIO_TECNICO_SQL());
                    $i = 1;
                    $conn->bindValue($i++, $useVO->getNomeEmpresa());
                    $conn->bindValue($i++, $useVO->getId());
                    $conn->execute();
                    break;
                case USUARIO_FUNCIONARIO:
                    $conn = $this->conn->prepare(USUARIO_SQL::ALTERAR_USUARIO_FUNCIONARIO_SQL());
                    $i = 1;
                    $conn->bindValue($i++, $useVO->getIdSetor());
                    $conn->bindValue($i++, $useVO->getId());
                    $conn->execute();
                    break;
            }

            // Processo de alteração de endereço
            $conn = $this->conn->prepare(USUARIO_SQL::VERIFICAR_CIDADE_CADASTRADA_SQL());
            $i = 1;
            $conn->bindValue($i++, $useVO->getCidade());
            $conn->bindValue($i++, $useVO->getEstado());
            $conn->execute();
            $tem_cidade = $conn->fetchAll(\PDO::FETCH_ASSOC);

            $id_cidade = 0;
            if (count($tem_cidade) > 0) {
                $id_cidade = $tem_cidade[0]['id_cidade'];
            } else {
                // Se a cidade não foi encontrada, verifica o estado
                $id_estado = 0;
                $conn = $this->conn->prepare(USUARIO_SQL::VERIFICAR_ESTADO_CADASTRADA_SQL());
                $conn->bindValue(1, $useVO->getEstado());
                $conn->execute();
                $tem_estado = $conn->fetchAll(\PDO::FETCH_ASSOC);

                if (count($tem_estado) > 0) {
                    $id_estado = $tem_estado[0]['id_estado'];
                } else {
                    // Se o estado não foi encontrado, cadastra um novo estado
                    $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_ESTADO_SQL());
                    $conn->bindValue(1, $useVO->getEstado());
                    $conn->execute();
                    $id_estado = $this->conn->lastInsertId();
                }

                // Cadastra a cidade associada ao estado
                $conn = $this->conn->prepare(USUARIO_SQL::CADASTRAR_CIDADE_SQL());
                $i = 1;
                $conn->bindValue($i++, $useVO->getCidade());
                $conn->bindValue($i++, $id_estado);
                $conn->execute();
                $id_cidade = $this->conn->lastInsertId();
            }

            // Atualiza o endereço do usuário
            $conn = $this->conn->prepare(USUARIO_SQL::ALTERAR_ENDERECO_SQL());
            $i = 1;
            $conn->bindValue($i++, $useVO->getRua());
            $conn->bindValue($i++, $useVO->getBairro());
            $conn->bindValue($i++, $useVO->getCep());
            $conn->bindValue($i++, $id_cidade);
            $conn->bindValue($i++, $useVO->getEnderecoId());
            $conn->execute();

            // Commit da transação
            $this->conn->commit();

            return 1;
        } catch (\Exception $ex) {
            // Em caso de erro, faz o rollback da transação
            $this->conn->rollBack();
            $useVO->setErroTec($ex->getMessage());
            parent::GravarLogErro($useVO);
            return -1;
        }
    
    }

    // Filtra usuários com base no nome informado
    public function FiltrarUsuarioModel(string $nome_usuario): array
    {
        $conn = $this->conn->prepare(USUARIO_SQL::FILTRO_USUARIO_SQL());
        $conn->bindValue(1, "$nome_usuario%"); // Realiza filtro usando o nome do usuário
        $conn->execute();
        return $conn->fetchAll(\PDO::FETCH_ASSOC); // Retorna a lista de usuários filtrados
    }

    // Detalha as informações de um usuário específico
    public function DetalharUsuarioModel(int $id_usuario): array | bool
    {
        $conn = $this->conn->prepare(USUARIO_SQL::DETALHAR_USUARIO_SQL());
        $conn->bindValue(1, $id_usuario);
        $conn->execute();
        return $conn->fetch(\PDO::FETCH_ASSOC); // Retorna as informações detalhadas do usuário
    }

    // Inativa um usuário, alterando seu status
    public function InativarUsuarioModel(UsuarioVO $userVO): int
    {
        $conn = $this->conn->prepare(USUARIO_SQL::INATIVAR_USUARIO_SQL());
        $conn->bindValue(1, $userVO->getStatus());
        $conn->bindValue(2, $userVO->getId());

        try {
            $conn->execute();
            return 1; // Retorna 1 indicando sucesso
        } catch (\Exception $ex) {
            $userVO->setErroTec($ex->getMessage());
            parent::GravarLogErro($userVO); // Registra erro
            return -1; // Retorna -1 indicando erro
        }
    }

    // Registra o log de acesso do usuário
    public function RegistrarLogAcesso(string $data, int $idUser): void
    {
        $sql = $this->conn->prepare(USUARIO_SQL::REGISTRAR_LOG_ACESSO());
        $sql->bindValue(1, $data);
        $sql->bindValue(2, $idUser);
        $sql->execute();
    }

    // Busca a senha do usuário
    public function BuscarSenhaUsuarioModel(int $id): array | null
    {
        $sql = $this->conn->prepare(USUARIO_SQL::BUSCAR_SENHA_USUARIO_SQL());
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetch(\PDO::FETCH_ASSOC); // Retorna a senha do usuário
    }

    // Altera a senha do usuário
    public function AlterarSenhaUsuarioModel(UsuarioVO $vo): int
    {
        $conn = $this->conn->prepare(USUARIO_SQL::ALTERAR_SENHA_USUARIO_SQL());
        $conn->bindValue(1, $vo->getSenha());
        $conn->bindValue(2, $vo->getId());

        try {
            $conn->execute();
            return 1; // Retorna 1 indicando sucesso
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return -1; // Retorna -1 indicando erro
        }
    }

    // Verifica se o CPF informado já está cadastrado
    public function VerificarCpfCadastradoModel($cpf_usuario): bool
    {
        $conn = $this->conn->prepare(USUARIO_SQL::BUSCAR_CPF());
        $conn->bindValue(1, $cpf_usuario);
        $conn->execute();

        $ver_cpf = $conn->fetch(\PDO::FETCH_ASSOC); // Obtém o resultado da consulta
        return $ver_cpf['contar'] == 0 ? false : true; // Retorna true se o CPF estiver cadastrado, caso contrário, false
    }
}
