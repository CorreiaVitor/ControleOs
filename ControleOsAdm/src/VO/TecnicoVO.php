<?php

namespace Src\VO;
use Src\Public\Util;

class TecnicoVO extends UsuarioVO
{
    private int $id_usuario;
    private string $nome_empresa;
    

    // Função que define o ID do usuário
    public function setidUsuario(int $p_id_usuario) : void
    {
        $this->id_usuario = $p_id_usuario;
    }
    // Função que retorna o ID do usuário
    public function getidUsuario() : int
    {
        return $this->id_usuario;
    }

    
    // Função que define o nome da empresa
    public function setNomeEmpresa(string $p_nome_empresa) : void
    {
        $this->nome_empresa = Util::DadosMaliciosos($p_nome_empresa);
    }
    // Função que retorna o nome da empresa
    public function getNomeEmpresa() : string
    {
        return $this->nome_empresa;
    }
}

?>