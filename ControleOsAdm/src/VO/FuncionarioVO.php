<?php

namespace Src\VO;


class FuncionarioVO extends UsuarioVO
{
    private int $id_usuario;
    private int $id_setor;

    // Função que define o ID do usuário
    public function setIdUsuario(int $p_id_usuario): void
    {
        $this->id_usuario = $p_id_usuario;
    }

    // Função que retorna o ID do usuário
    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }

    // Função que define o ID do setor equipamento
    public function setIdsetor(int $p_id_setor): void
    {
        $this->id_setor = $p_id_setor;
    }

    // Função que retorna o ID do setor equipamento
    public function getIdSetor(): int
    {
        return $this->id_setor;
    }
}
