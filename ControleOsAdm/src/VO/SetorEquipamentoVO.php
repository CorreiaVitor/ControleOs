<?php 

namespace Src\VO;

use Src\public\Util;

class SetorEquipamentoVO extends LogErroVO
{
    private int $id;
    private string $nome;
    
    //função que define o valor do ID pelo parametro $p_id
    public function setIdSetor(int $p_id): void
    {
        $this->id = $p_id;
    }

    // Funçao que retorna o valor da propriedade ID
    public function getIdSetor(): int
    {
        return $this->id;
    }

     //Função que define o Nome pelo parametro $p_nome
    public function setNomeSetor(string $p_nome) : void
    {
        $this->nome = Util::TratarDadosGerais($p_nome);
    }

    // Funçao que retorna o valor da propriedade Nome
    public function getNomeSetor() : string
    {
        return $this->nome;
    }
}

?>