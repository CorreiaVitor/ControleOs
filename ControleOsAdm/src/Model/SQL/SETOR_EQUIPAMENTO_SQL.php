<?php

// Definição da classe SETOR_EQUIAPMENTO_SQL
namespace Src\Model\SQL;

class SETOR_EQUIPAMENTO_SQL 
{
    // Método para retornar SQL de cadastro de setor de equipamento
    public static function CADASTRAR_SETOR_EQUIPAMENTO(): string
    {
        $sql = 'INSERT INTO tb_setor (nome_setor) VALUES (?)';
        return $sql;
    }
    
    // Método para retornar SQL de detalhamento de setor de equipamento
    public static function DETALHAR_SETOR_EQUIPAMENTO(): string
    {
        $sql = 'SELECT id_setor, nome_setor FROM tb_setor';
        return $sql;
    }

    // Método para retornar SQL de alteração de setor de equipamento
    public static function ALTERAR_SETOR_EQUIPAMENTO(): string
    {
        $sql = 'UPDATE tb_setor SET nome_setor = ? WHERE id_setor = ?';
        return $sql;
    }
    
    // Método para retornar SQL de exclusão de setor de equipamento
    public static function EXCLUIR_SETOR_EQUIPAMENTO(): string
    {
        $sql = 'DELETE FROM tb_setor WHERE id_setor = ?';
        return $sql;
    }
}

?>
