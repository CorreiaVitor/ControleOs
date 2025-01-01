<?php

namespace Src\Model\SQL;

class CHAMADO_SQL
{

    // SQL para abrir um chamado, inserindo os detalhes básicos
    public static function ABRIR_CHAMADO_SQL(): string
    {
        $sql = 'INSERT INTO tb_chamado (data_abertura, hora_abertura, problema, funcionario_id, id_alocar) VALUES (?,?,?,?,?)';

        return $sql;
    }

    // SQL para registrar que um chamado está sendo atendido por um técnico
    public static function ATENDER_CHAMADO_SQL(): string
    {
        $sql = 'UPDATE tb_chamado SET data_atendimento = ?, hora_atendimento = ?, tecnico_atendimento_id = ? WHERE id_chamado = ?';

        return $sql;
    }

    // SQL para finalizar um chamado, registrando a conclusão
    public static function FINALIZAR_CHAMADO_SQL(): string
    {
        $sql = 'UPDATE tb_chamado SET data_encerramento = ?, hora_encerramento = ?, laudo = ?, tecnico_finalizar_id = ? WHERE id_chamado = ?';

        return $sql;
    }

    // SQL para atualizar a situação de um alocamento
    public static function ATUALIZAR_ALOCAMENTO_SQL(): string
    {
        $sql = 'UPDATE 
                  tb_alocar 
                SET
                  situacao_alocar = ? 
                WHERE 
                  id_alocar = ?';

        return $sql;
    }

    // SQL para filtrar chamados com base em sua situação e setor
    public static function FILTRAR_CHAMADO($situacao, $setor): string
    {
        $sql = 'SELECT 
                    equip.identificacao,
                    tipo.nome_tipo,
                    modelo.nome_modelo,
                    chamado.id_chamado,
                    chamado.data_abertura AS data_abertura,
                    chamado.problema,
                    chamado.data_atendimento AS data_atendimento,
                    chamado.data_encerramento AS data_encerramento,
                    chamado.tecnico_atendimento_id AS tec_atendimento,
                    chamado.tecnico_finalizar_id AS tec_finalizar,
                    chamado.laudo,
                    chamado.id_alocar,
                    usuario_tec_atend.nome_usuario AS tecnico_atendimento,
                    usuario_tec_final.nome_usuario AS tecnico_finalizado,
                    usuario_func.nome_usuario AS funcionario
                FROM
                    tb_chamado AS chamado
                        INNER JOIN
                    tb_funcionario AS func ON chamado.funcionario_id = func.id_usuario
                        INNER JOIN
                    tb_usuario AS usuario_func ON func.id_usuario = usuario_func.id_usuario
                        INNER JOIN
                    tb_alocar AS alocar ON chamado.id_alocar = alocar.id_alocar
                        INNER JOIN
                    tb_equipamento AS equip ON alocar.equipamento_id = equip.id_equipamento
                        INNER JOIN
                    tb_tipo AS tipo ON equip.tipo_id = tipo.id_tipo
                        INNER JOIN
                    tb_modelo AS modelo ON equip.modelo_id = modelo.id_modelo
                        LEFT JOIN
                    tb_tecnico AS tec_atend ON chamado.tecnico_atendimento_id = tec_atend.id_usuario
                        LEFT JOIN
                    tb_usuario AS usuario_tec_atend ON tec_atend.id_usuario = usuario_tec_atend.id_usuario
                        LEFT JOIN
                    tb_tecnico AS tec_finaliza ON chamado.tecnico_finalizar_id = tec_finaliza.id_usuario
                        LEFT JOIN
                    tb_usuario AS usuario_tec_final ON tec_finaliza.id_usuario = usuario_tec_final.id_usuario';

        // Adiciona condições baseadas na situação do chamado
        switch ($situacao) {
            case SITUACAO_CHAMADO_AGUARDANDO_ATENDIMENTO:
                $sql .= ' WHERE chamado.tecnico_atendimento_id IS NULL' . ($setor ? ' AND alocar.setor_id = ?' : '');
                break;
            case SITUACAO_CHAMADO_EM_ATENDIMENTO:
                $sql .= ' WHERE chamado.tecnico_atendimento_id IS NOT NULL AND chamado.tecnico_finalizar_id IS NULL' . ($setor ? ' AND alocar.setor_id = ?' : '');
                break;
            case SITUACAO_CHAMADO_FINALIZADO:
                $sql .= ' WHERE chamado.tecnico_finalizar_id IS NOT NULL' . ($setor ? ' AND alocar.setor_id = ?' : '');
                break;
            default:
                $sql .= ($setor ? ' WHERE alocar.setor_id = ? ' : '');
                break;
        }

        return $sql;
    }

    // SQL para detalhar um chamado específico pelo seu ID
    public static function DETALHAR_CHAMADO_SQL(): string
    {
        $sql = 'SELECT 
                    chamado.id_chamado,
                    equip.identificacao,
                    tipo.nome_tipo,
                    modelo.nome_modelo,
                    chamado.data_abertura AS data_abertura,
                    chamado.problema,
                    chamado.data_atendimento AS data_atendimento,
                    chamado.data_encerramento AS data_encerramento,
                    chamado.tecnico_atendimento_id AS tec_atendimento,
                    chamado.tecnico_finalizar_id AS tec_finalizar,
                    chamado.laudo,
                    chamado.id_alocar,
                    usuario_tec_atend.nome_usuario AS tecnico_atendimento,
                    usuario_tec_final.nome_usuario AS tecnico_finalizado,
                    usuario_func.nome_usuario AS funcionario
                FROM
                    tb_chamado AS chamado
                        INNER JOIN
                    tb_funcionario AS func ON chamado.funcionario_id = func.id_usuario
                        INNER JOIN
                    tb_usuario AS usuario_func ON func.id_usuario = usuario_func.id_usuario
                        INNER JOIN
                    tb_alocar AS alocar ON chamado.id_alocar = alocar.id_alocar
                        INNER JOIN
                    tb_equipamento AS equip ON alocar.equipamento_id = equip.id_equipamento
                        INNER JOIN
                    tb_tipo AS tipo ON equip.tipo_id = tipo.id_tipo
                        INNER JOIN
                    tb_modelo AS modelo ON equip.modelo_id = modelo.id_modelo
                        LEFT JOIN
                    tb_tecnico AS tec_atend ON chamado.tecnico_atendimento_id = tec_atend.id_usuario
                        LEFT JOIN
                    tb_usuario AS usuario_tec_atend ON tec_atend.id_usuario = usuario_tec_atend.id_usuario
                        LEFT JOIN
                    tb_tecnico AS tec_finaliza ON chamado.tecnico_finalizar_id = tec_finaliza.id_usuario
                        LEFT JOIN
                    tb_usuario AS usuario_tec_final ON tec_finaliza.id_usuario = usuario_tec_final.id_usuario
                WHERE chamado.id_chamado = ?';

        return $sql;
    }

    // SQL para obter números atuais de chamados em diferentes situações
    public static function NUMEROS_CHAMADOS_ATUAL()
    {
        $sql = 'SELECT 
                    (SELECT 
                            COUNT(id_chamado)
                        FROM
                            tb_chamado
                        WHERE
                            tecnico_atendimento_id IS NULL) AS qtd_aguardando,
                    (SELECT 
                            COUNT(id_chamado)
                        FROM
                            tb_chamado
                        WHERE
                            tecnico_atendimento_id IS NOT NULL
                                AND tecnico_finalizar_id IS NULL) AS qtd_em_atendimento,
                    (SELECT 
                            COUNT(id_chamado)
                        FROM
                            tb_chamado
                        WHERE
                            tecnico_finalizar_id IS NOT NULL) AS qtd_encerrado';
        return $sql;
    }
}
