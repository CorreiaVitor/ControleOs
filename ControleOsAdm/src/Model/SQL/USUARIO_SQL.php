<?php

namespace Src\Model\SQL;

class USUARIO_SQL
{
    // SQL para verificar se o email do usuário já está cadastrado
    public static function VERIFICAR_EMAIL_CADASTRADO(): string
    {
        $sql = 'SELECT 
                    count(email_usuario) AS contar_email_usuario
                FROM
                    tb_usuario
                WHERE 
                    email_usuario = ?';

        return $sql;
    }

    // SQL para validar o login do usuário usando o CPF e o status
    public static function VALIDAR_LOGIN_SQL(): string
    {
        $sql = 'SELECT 
                    tb_usuario.id_usuario,
                    nome_usuario,
                    senha_usuario,
                    setor_id,
                    nome_empresa
                FROM
                    tb_usuario
                        LEFT JOIN
                    tb_funcionario ON tb_usuario.id_usuario = tb_funcionario.id_usuario
                        LEFT JOIN
                    tb_tecnico ON tb_usuario.id_usuario = tb_tecnico.id_usuario
                WHERE
                    cpf_usuario = ?
                        AND status_usuario = ?';

        return $sql;
    }

    // SQL para cadastrar um novo estado
    public static function CADASTRAR_ESTADO_SQL(): string
    {
        $sql = 'INSERT INTO tb_estado (sigla_estado)VALUES(?)';

        return $sql;
    }

    // SQL para cadastrar uma nova cidade associada a um estado
    public static function CADASTRAR_CIDADE_SQL(): string
    {
        $sql = 'INSERT INTO tb_cidade(nome_cidade, estado_id)VALUES(?,?)';

        return $sql;
    }

    // SQL para cadastrar um novo endereço para um usuário
    public static function CADASTRAR_ENDERECO_SQL(): string
    {
        $sql = 'INSERT INTO tb_endereco (rua, bairro, cep, usuario_id, cidade_id)VALUES(?,?,?,?,?)';

        return $sql;
    }

    // SQL para cadastrar um novo usuário
    public static function CADASTRAR_USUARIO_SQL(): string
    {
        $sql = 'INSERT INTO tb_usuario (nome_usuario, tipo_usuario, email_usuario, cpf_usuario, senha_usuario, status_usuario, tel_usuario)VALUES(?,?,?,?,?,?,?)';

        return $sql;
    }

    // SQL para cadastrar um novo usuário do tipo técnico
    public static function CADASTRAR_USUARIO_TECNICO_SQL(): string
    {
        $sql = 'INSERT INTO tb_tecnico (id_usuario, nome_empresa)VALUES(?, ?)';

        return $sql;
    }

    // SQL para cadastrar um novo usuário do tipo funcionário
    public static function CADASTRAR_USUARIO_FUNCIONARIO_SQL(): string
    {
        $sql = 'INSERT INTO tb_funcionario (id_usuario, setor_id)VALUES(?, ?)';

        return $sql;
    }

    // SQL para verificar se uma cidade já está cadastrada, com base no nome e estado
    public static function VERIFICAR_CIDADE_CADASTRADA_SQL(): string
    {
        $sql = 'SELECT 
                    id_cidade
                FROM
                    tb_cidade
                        INNER JOIN
                    tb_estado ON tb_cidade.estado_id = tb_estado.id_estado
                WHERE
                    tb_cidade.nome_cidade = ?
                        AND tb_estado.sigla_estado = ?';

        return $sql;
    }

    // SQL para verificar se um estado já está cadastrado
    public static function VERIFICAR_ESTADO_CADASTRADA_SQL(): string
    {
        $sql = 'SELECT 
                    id_estado
                FROM
                    tb_estado
                WHERE 
                    sigla_estado = ?';

        return $sql;
    }

    // SQL para filtrar usuários com base em seu nome
    public static function FILTRO_USUARIO_SQL(): string
    {
        $sql = 'SELECT 
                    id_usuario, nome_usuario, tipo_usuario, status_usuario
                FROM 
                    tb_usuario
                WHERE 
                    nome_usuario LIKE ?';

        return $sql;
    }

    // SQL para detalhar as informações de um usuário, incluindo endereço e tipo
    public static function DETALHAR_USUARIO_SQL(): string
    {
        $sql = 'SELECT 
                    tb_usuario.id_usuario,
                    nome_usuario,
                    tipo_usuario,
                    cpf_usuario,
                    tel_usuario,
                    email_usuario,
                    nome_empresa,
                    setor_id,
                    nome_setor,
                    rua,
                    bairro,
                    cep,
                    cidade_id,
                    nome_cidade,
                    sigla_estado,
                    id_endereco
                FROM
                    tb_usuario
                        INNER JOIN
                    tb_endereco ON tb_usuario.id_usuario = tb_endereco.usuario_id
                        INNER JOIN
                    tb_cidade ON tb_endereco.cidade_id = tb_cidade.id_cidade
                        INNER JOIN
                    tb_estado ON tb_cidade.estado_id = tb_estado.id_estado
                        LEFT JOIN
                    tb_tecnico ON tb_usuario.id_usuario = tb_tecnico.id_usuario
                        LEFT JOIN
                    tb_funcionario ON tb_usuario.id_usuario = tb_funcionario.id_usuario
                        LEFT JOIN
                    tb_setor ON tb_funcionario.setor_id = tb_setor.id_setor
                WHERE 
                    tb_usuario.id_usuario = ?';

        return $sql;
    }

    // SQL para alterar os dados de um usuário (nome, email, CPF, senha, telefone)
    public static function ALTERAR_USUARIO_SQL(): string
    {
        $sql = 'UPDATE 
                    tb_usuario
                SET 
                    nome_usuario = ?,
                    email_usuario = ?,
                    cpf_usuario = ?,
                    senha_usuario = ?,
                    tel_usuario = ?
                WHERE 
                    id_usuario = ?';

        return $sql;
    }

    // SQL para alterar o setor de um usuário do tipo funcionário
    public static function ALTERAR_USUARIO_FUNCIONARIO_SQL(): string
    {
        $sql = 'UPDATE 
                    tb_funcionario
                SET 
                    setor_id = ?
                WHERE 
                    id_usuario = ?';

        return $sql;
    }

    // SQL para alterar o nome da empresa de um usuário do tipo técnico
    public static function ALTERAR_USUARIO_TECNICO_SQL(): string
    {
        $sql = 'UPDATE 
                    tb_tecnico
                SET 
                    nome_empresa = ?
                WHERE 
                    id_usuario = ?';

        return $sql;
    }

    // SQL para alterar o endereço de um usuário
    public static function ALTERAR_ENDERECO_SQL(): string
    {
        $sql = 'UPDATE 
                    tb_endereco
                SET 
                    rua = ?,
                    bairro = ?,
                    cep = ?,
                    cidade_id = ?
                WHERE 
                    id_endereco = ?';

        return $sql;
    }

    // SQL para inativar um usuário, alterando seu status
    public static function INATIVAR_USUARIO_SQL(): string
    {
        $sql = 'UPDATE 
                    tb_usuario
                SET
                    status_usuario = ?
                WHERE
                    id_usuario = ?';

        return $sql;
    }

    // SQL para registrar o log de acesso de um usuário
    public static function REGISTRAR_LOG_ACESSO()
    {
        $sql = 'INSERT INTO tb_log (data, usuario_id) VALUES (?, ?)';

        return $sql;
    }

    // SQL para buscar a senha de um usuário específico
    public static function BUSCAR_SENHA_USUARIO_SQL(): string
    {
        $sql = 'SELECT 
                   senha_usuario 
                FROM 
                   tb_usuario 
                WHERE 
                   id_usuario = ?';

        return $sql;
    }

    // SQL para alterar a senha de um usuário
    public static function ALTERAR_SENHA_USUARIO_SQL(): string
    {
        $sql = 'UPDATE 
                  tb_usuario 
                SET 
                  senha_usuario = ? 
                WHERE 
                  id_usuario = ?';

        return $sql;
    }

    // SQL para verificar se o CPF de um usuário já está cadastrado
    public static function BUSCAR_CPF(){ 
        $sql = 'SELECT COUNT(cpf_usuario) as contar FROM tb_usuario WHERE cpf_usuario  = ?';

        return $sql;
    }

}
