<?php

namespace Src\VO;
use Src\Public\Util;

class AlocarVO extends LogErroVO
{
    private int $id; 
    private int $id_equipamento; 
    private int $id_setor;
    private string $situacao;


    // Função que define o ID do alocamento 
    public function setId(int $id_p) : void 
    {
        $this->id = $id_p;
    }
    // Função que retorna o ID do alocamento
    public function getId() : int 
    {
        return $this->id;
    }

    // Função que define o ID do equipamento 
    public function setEquipamentoId(int $id_equi_p) : void 
    {
        $this->id_equipamento = $id_equi_p;
    }
    // Função que retorna o ID do equipamento
    public function getEquipamentoId() : int
    {
        return $this->id_equipamento;
    }


    // Função que define o ID do setor do equipamento
    public function setSetorId(int $id_setor_p) : void 
    {
        $this->id_setor = $id_setor_p;
    }
    // Função que retorna o ID do setor do equipamento
    public function getSetorId() : int 
    {
        return $this->id_setor;
    }

    // Função que define a situacao do equipamento
    public function setSituacao(int $situ_p) : void
    {
        $this->situacao = $situ_p;
    }
    // Função que retorna a situacao do equipamento
    public function getSituacao() : int
    {
        return $this->situacao;
    }

    // Função que define a data remoção do equipamento 
    public function getDataAlocar() : string
    {
        return Util::DataAtual();
    }
    // Função que define a data remoção do equipamento 
    public function getDataRemocao() : string
    {
        return Util::DataAtual();
    }

}


?>