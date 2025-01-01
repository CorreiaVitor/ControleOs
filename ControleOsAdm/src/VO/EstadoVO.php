<?php

namespace Src\VO;

use Src\Public\Util;

class EstadoVO
{
    private int $id;
    private string $nome_estado;
    private string $sigla_estado;

    // Função que define o ID do estado
    public function setId(int $id_p): void
    {
        $this->id = $id_p;
    }
    // Função que retorna o ID do estado
    public function getId(): string
    {
        return $this->id;
    }


    // Função que define o nome do estado
    public function setNomeEstado(string $p_nome_estado): void
    {
        $this->nome_estado = Util::TratarDadosGerais($p_nome_estado);
    }
    // Função que retorna o nome do estado
    public function getNomeEstado(): string
    {
        return $this->nome_estado;
    }


    // Função que define a sigla do estado
    public function setIdEstado(string $p_sigla_estado): void
    {
        $this->sigla_estado = Util::TratarDadosGerais($p_sigla_estado);
    }
    // Função que retorna a sigla do estado
    public function getIdEstado(): string
    {
        return $this->sigla_estado;
    }
}
