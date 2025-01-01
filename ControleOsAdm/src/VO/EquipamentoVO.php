<?php

namespace Src\VO;

use Src\public\Util;

class EquipamentoVO extends LogErroVO
{
    private int $id;
    private int $id_tipo;
    private int $id_modelo;
    private string $identificacao;
    private string $descricao;
    private int $situacao;
    private string $motivo_descarte;
    private string $data_descarte;

    // Função que define o ID do equipamento 
    public function setIdEquipamento(int $p_id): void
    {
        $this->id = $p_id;
    }
    // Função que retorna o ID do equipamento
    public function getIdEquipamento(): int
    {
        return $this->id;
    }

    // Função que define o ID do Tipo equipamento 
    public function setIdTipo(int $p_id_tipo): void
    {
        $this->id_tipo = $p_id_tipo;
    }
    // Função que retorna o ID do Tipo equipamento
    public function getIdTipo(): int
    {
        return $this->id_tipo;
    }

    // Função que define o ID do Modelo equipamento 
    public function setIdModelo(int $p_id_modelo): void
    {
        $this->id_modelo = $p_id_modelo;
    }
    // Função que retorna o ID do Modelo equipamento
    public function getIdModelo(): int
    {
        return $this->id_modelo;
    }

    // Função que define a indentificação do equipamento 
    public function setIdentificacao(string $p_identificacao): void
    {
        $this->identificacao = Util::DadosMaliciosos($p_identificacao);
    }

    // Função que retorna a indentificação do equipamento 
    public function getIdentificacao(): string
    {
        return $this->identificacao;
    }
    
    // Função que define a descrição do equipamento 
    public function setDescricao(string $p_descricao): void
    {
        $this->descricao = Util::DadosMaliciosos($p_descricao);
    }

    // Função que retorna a descrição do equipamento 
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    // Função que define a situação do equipamento 
    public function setSituacao(string $p_situacao): void
    {
        $this->situacao = Util::DadosMaliciosos($p_situacao);
    }

    // Função que retorna a situação do equipamento 
    public function getSituacao(): string
    {
        return $this->situacao;
    }

    // Função que define o Motivo do descarte do equipamento 
    public function setMotivoDescarte(string $p_motivo_descarte): void
    {
        $this->motivo_descarte = Util::DadosMaliciosos($p_motivo_descarte);
    }

    // Função que retorna o Motivo do descarte do equipamento 
    public function getMotivoDescarte(): string
    {
        return $this->motivo_descarte;
    }

    // Função que define a data do descarte do equipamento 
    public function setDataDescarte(string $p_data_descarte): void
    {
        $this->data_descarte = $p_data_descarte;
    }

    // Função que retorna a data descarte do equipamento 
    public function getDataDescarte(): string
    {
        return $this->data_descarte;;
    }
    
}
