<?php

namespace Src\VO;

use Src\public\Util;

class TipoEquipamentoVO extends LogErroVO
{
    private int $id;
    private string $nome;

    //função que define o valor do ID pelo parametro $p_id
    public function setIdTipo(int $p_id): void
    {
        $this->id = $p_id;
    }

    // Funçao que retorna o valor da propriedade ID
    public function getIdTipo(): int
    {
        return $this->id;
    }

    //Função que define o Nome pelo parametro $p_nome
    public function setNomeTipo(string $p_nome): void
    {
        $this->nome = Util::TratarDadosGerais($p_nome);
    }
    
    // Funçao que retorna o valor da propriedade Nome
    public function getNomeTipo(): string
    {
        return $this->nome;
    }
}
