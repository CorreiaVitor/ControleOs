<?php

namespace Src\VO;

use Src\Public\Util;

class CidadeVO
{
    private int $id;
    private int $id_estado;
    private string $nome_cidade;

    // Função que define o ID da cidade
    public function setId(int $p_id): void
    {
        $this->id = $p_id;
    }
    // Função que retorna o ID da cidade
    public function getId(): string
    {
        return $this->id;
    }

    // Função que define o ID do estado 
    public function setIdEstado(string $p_id_estado): void
    {
        $this->id_estado = Util::TratarDadosGerais($p_id_estado);
    }
    // Função que retorna o ID do estado
    public function getIdEstado(): string
    {
        return $this->id_estado;
    }

    // Função que define o nome da cidade 
    public function setNomeCidade(string $p_nome_cidade): void
    {
        $this->nome_cidade = Util::TratarDadosGerais($p_nome_cidade);
    }
    // Função que retorna o nome da cidade
    public function getNomeCidade(): string
    {
        return $this->nome_cidade;
    }
}
