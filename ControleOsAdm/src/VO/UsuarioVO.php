<?php

namespace Src\VO;

use Src\Public\Util;

class UsuarioVO extends EnderecoVO
{
    private int $id;
    private string $nome;
    private int $tipo_usuario;
    private string $email;
    private string $cpf;
    private string $senha;
    private string $telefone;
    private int $status;

    // Função que define o ID do usuário
    public function setId(int $p_id): void
    {
        $this->id = $p_id;
    }
    // Função que retorna o ID do usuário
    public function getId(): int
    {
        return $this->id;
    }

    // Função que define o nome do usuário
    public function setNome(string $p_nome): void
    {
        $this->nome = Util::TratarDadosGerais($p_nome);
    }

    // Função que retorna o nome do usuário
    public function getNome(): string
    {
        return $this->nome;
    }

    // Função que define o tipo do usuário (ADM, FUNCIONÁRIO ou TÉCNICO)
    public function setTipoUsuario(string $p_tipo_usuario): void
    {
        $this->tipo_usuario = $p_tipo_usuario;
    }
    // Função que retorna o tipo do usuário (ADM, FUNCIONÁRIO ou TÉCNICO)
    public function getTipo(): int
    {
        return $this->tipo_usuario;
    }

    // Função que define o email do usuário 
    public function setEmail(string $p_email): void
    {
        $this->email = Util::DadosMaliciosos($p_email);
    }
    // Função que retorna o email do usuário
    public function getEmail(): string
    {
        return $this->email;
    }

    // Função que define o cpf do usuário
    public function setCpf(string $p_cpf): void
    {
        $this->cpf = Util::TratarDadosGerais($p_cpf);
    }
    // Função que retorna o cpf do usuário
    public function getCpf(): string
    {
        return $this->cpf;
    }

    // Função que define a senha do usuário
    public function setSenha(string $p_senha): void
    {
        $this->senha = $p_senha;
    }
    // Função que retorna a senha do usuário
    public function getSenha(): string
    {
        return $this->senha;
    }

    // Função que define telefone do usuário
    public function setTelefone(string $p_tel): void
    {
        $this->telefone = Util::TratarDadosGerais($p_tel);
    }
    // Função que retorna telefone do usuário
    public function getTelefone(): string
    {
        return $this->telefone;
    }

    // Função que define o status do usuario (ativo ou inativo)
    public function setStatus(int $p_status): void
    {
        $this->status = $p_status;
    }
    // Função que retorna o status do usuario (ativo ou inativo)
    public function getStatus(): int | null
    {
        return $this->status;
    }
}

?>