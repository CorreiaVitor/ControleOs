<?php

namespace Src\Model\SQL;

class EQUIPAMENTO_SQL
{
    // SQL para cadastrar um novo equipamento, com seus detalhes
    public static function CADASTRAR_EQUIPAMENTO_SQL(): string
    {
        $sql = 'INSERT INTO 
                    tb_equipamento (identificacao, descricao, situacao, tipo_id, modelo_id) 
                VALUE 
                    (?,?,?,?,?)';

        return $sql;
    }

    // SQL para alterar os dados de um equipamento já existente
    public static function ALTERAR_EQUIPAMENTOS_SQL(): string
    {
        $sql = 'UPDATE 
                  tb_equipamento 
                SET 
                  identificacao = ?, descricao = ?, tipo_id = ?, modelo_id = ?
                WHERE
                  id_equipamento = ?';
        return $sql;
    }

    // SQL para excluir um equipamento do sistema
    public static function EXCLUIR_EQUIPAMENTO_SQL(): string
    {
        $sql = 'DELETE FROM tb_equipamento WHERE id_equipamento = ?';

        return $sql;
    }

    // SQL para filtrar equipamentos, considerando tipo e modelo, além de verificar alocação
    public static function FILTRAR_EQUIPAMENTO_SQL(int $idTipo, int $idModelo): string
    {
        $sql = 'SELECT 
            id_equipamento,
            identificacao,
            descricao,
            situacao,
            data_descarte,
            motivo_descarte,
            tipo_id,
            modelo_id,
            nome_tipo,
            nome_modelo,
                    (SELECT 
                        COUNT(*)
                    FROM
                        tb_alocar
                    WHERE
                        equipamento_id = id_equipamento 
                    AND situacao_alocar != ?) AS esta_alocado                                 
        FROM
            tb_equipamento
                INNER JOIN
            tb_tipo ON tb_equipamento.tipo_id = tb_tipo.id_tipo
                INNER JOIN
            tb_modelo ON tb_equipamento.modelo_id = tb_modelo.id_modelo
        WHERE
            nome_tipo LIKE ?';

        // Filtra conforme os parâmetros de tipo e modelo, se fornecidos
        if ($idTipo != 0 && $idModelo != 0) {
            $sql .= ' AND tipo_id = ? AND modelo_id = ? ';
        } else if ($idTipo == 0 && $idModelo != 0) {
            $sql .= ' AND modelo_id = ? ';
        } else if ($idTipo != 0 && $idModelo == 0) {
            $sql .= ' AND tipo_id = ? ';
        }

        return $sql;
    }

    // SQL para detalhar as informações de um equipamento específico
    public static function DETALHAR_EQUIPAMENTO_SQL(): string
    {
        $sql = 'SELECT 
                   id_equipamento,
                   identificacao,
                   descricao,
                   tipo_id,
                   modelo_id
                FROM 
                    tb_equipamento
                WHERE 
                    id_equipamento = ?';

        return $sql;
    }

    // SQL para realizar o descarte de um equipamento, alterando seu status
    public static function DESCARTA_EQUIPAMENTO_SQL(): string
    {
        $sql = 'UPDATE 
                  tb_equipamento 
                SET 
                  situacao = ?, data_descarte = ?, motivo_descarte = ? 
                WHERE 
                  id_equipamento = ?';

        return $sql;
    }

    // SQL para consultar equipamentos não alocados, considerando seu status
    public static function CONSULTAR_EQUIPAMENTO_NAO_ALOCADO_SQL(): string
    {
        $sql = 'SELECT 
                    id_equipamento, nome_tipo, nome_modelo, identificacao
                FROM
                    tb_equipamento
                        INNER JOIN
                    tb_tipo ON tb_equipamento.tipo_id = tb_tipo.id_tipo
                        INNER JOIN
                    tb_modelo ON tb_equipamento.modelo_id = tb_modelo.id_modelo
                WHERE
                    situacao = ? 
                        AND id_equipamento NOT IN (SELECT 
                            equipamento_id
                        FROM
                            tb_alocar
                        WHERE situacao_alocar != ?);';
        return $sql;
    }

    // SQL para alocar um equipamento a um setor, com a data e situação da alocação
    public static function ALOCAR_EQUIPAMENTO_SQL(): string
    {
        $sql = 'INSERT INTO 
                    tb_alocar (data_alocar, situacao_alocar, equipamento_id, setor_id)
                VALUES
                    (?,?,?,?)';

        return $sql;
    }

    // SQL para buscar equipamentos alocados em um setor específico
    public static function EQUIPAMENTO_ALOCADO_SETOR(): string
    {
        $sql = 'SELECT id_equipamento,
                        tb_equipamento.identificacao,
                        tb_tipo.nome_tipo,
                        tb_modelo.nome_modelo,
                        tb_alocar.id_alocar,
                        tb_alocar.situacao_alocar,
                        tb_alocar.data_alocar
                    FROM tb_equipamento
                INNER JOIN tb_tipo
                     ON tb_equipamento.tipo_id = tb_tipo.id_tipo
                INNER JOIN tb_modelo
                     ON tb_equipamento.modelo_id = tb_modelo.id_modelo
                INNER JOIN tb_alocar
                     ON tb_alocar.equipamento_id = tb_equipamento.id_equipamento
                WHERE tb_alocar.setor_id = ?
                     AND tb_alocar.data_remocao is null
                     AND tb_alocar.situacao_alocar = ?';

        return $sql;
    }

    // SQL para remover a alocação de um equipamento de um setor
    public static function REMOVER_EQUIPAMENTO_ALOCADO(): string
    {
       $sql = 'UPDATE 
                  tb_alocar 
               SET 
                  situacao_alocar = ?, data_remocao = ? 
                WHERE 
                  id_alocar = ?';

       return $sql;
    }
}
