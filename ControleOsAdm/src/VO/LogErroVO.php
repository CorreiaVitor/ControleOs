<?php

namespace Src\VO;
use Src\public\Util;

class LogErroVO
{

    private string $erroTec;
    private string $funcaoErro;
    private int $userLog;

    public function setErroTec($p_erro_tec) : void 
    {
        $this->erroTec = $p_erro_tec;
    }

    public function getErroTec(): string
    {
        return $this->erroTec;
    }

    public function setFuncaoErro($p_funcao_erro) : void 
    {
        $this->funcaoErro = $p_funcao_erro;
    }

    public function getFuncaoErro(): string
    {
        return $this->funcaoErro;
    }

    public function setUserLog($p_user_log) : void 
    {
        $this->userLog = $p_user_log;
    }

    public function getUserLog(): int
    {
        return $this->userLog;
    }
    
    public function getDataErro(): string
    {
        return Util::DataAtualBr();
    }

    public function getHoraErro(): string
    {
        return Util::HoraAtual();
    }

}

?>