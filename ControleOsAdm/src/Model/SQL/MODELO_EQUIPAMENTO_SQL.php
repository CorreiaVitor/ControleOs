<?php

// Definição da classe MODELO_EQUIAPMENTO_SQL
namespace Src\Model\SQL;

class MODELO_EQUIPAMENTO_SQL 
{
    // Método para retornar SQL de cadastro do modelo equipamento
    public static function CADASTRAR_MODELO_EQUIPAMENTO(): string
    {
        $sql = 'INSERT INTO tb_modelo (nome_modelo) VALUES (?)';
        return $sql;
    }
    
    // Método para retornar SQL de detalhamento dos modelos equipamentos
    public static function DETALHAR_MODELO_EQUIPAMENTO(): string
    {
        $sql = 'SELECT id_modelo, nome_modelo FROM tb_modelo';
        return $sql;
    }

    // Método para retornar SQL de alteração do modelo equipamento
    public static function ALTERAR_MODELO_EQUIPAMENTO(): string
    {
        $sql = 'UPDATE tb_modelo SET nome_modelo = ? WHERE id_modelo = ?';
        return $sql;
    }
    
    // Método para retornar SQL de exclusão do modelo equipamento
    public static function EXCLUIR_MODELO_EQUIPAMENTO(): string
    {
        $sql = 'DELETE FROM tb_modelo WHERE id_modelo = ?';
        return $sql;
    }
}

?>
