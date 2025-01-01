<?php

// Definição da classe TIPO_EQUIAPMENTO_SQL
namespace Src\Model\SQL;

class TIPO_EQUIPAMENTO_SQL 
{
    // Método para retornar SQL de cadastro de tipo de equipamento
    public static function CADASTRAR_TIPO_EQUIPAMENTO(): string
    {
        $sql = 'INSERT INTO tb_tipo (nome_tipo) VALUES (?)';
        return $sql;
    }
    
    // Método para retornar SQL de detalhamento de tipos de equipamento
    public static function DETALHAR_TIPO_EQUIPAMENTO(): string
    {
        $sql = 'SELECT id_tipo, nome_tipo FROM tb_tipo';
        return $sql;
    }

    // Método para retornar SQL de alteração de tipo de equipamento
    public static function ALTERAR_TIPO_EQUIPAMENTO(): string
    {
        $sql = 'UPDATE tb_tipo SET nome_tipo = ? WHERE id_tipo = ?';
        return $sql;
    }
    
    // Método para retornar SQL de exclusão de tipo de equipamento
    public static function EXCLUIR_TIPO_EQUIPAMENTO(): string
    {
        $sql = 'DELETE FROM tb_tipo WHERE id_tipo = ?';
        return $sql;
    }
}

?>
