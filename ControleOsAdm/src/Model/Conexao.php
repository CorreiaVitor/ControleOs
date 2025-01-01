<?php

namespace Src\Model;


//self comando que reaproveita comandos da mesma classe
//poo classe imbutida propria do php para interagir com todos os SGBDs (softwares de gerenciamento de SQL)
// Configurações do site
define('HOST', '127.0.0.1'); //IP
define('USER', 'root'); //usuario
define('PASS', null); //Senha
define('DB', 'db_controleos01'); //Banco
/**
 * Conexao.class TIPO [Conexão]
 * Descricao: Estabelece conexões com o banco usando SingleTon
 * @copyright (c) year, WMBarros
 */

class Conexao
{

    /** @var \PDO */
    private static $Connect;


    //funcao estatica nao cria objeto na memoria, funciona de forma direta
    //quando uma estrutura de funcao é padra, nao sofre alteracoes, podemos utilizar a funcao estatica
    private static function Conectar()
    {
        try {
            //Verifica se a conexão não existe
            if (self::$Connect == null) :
                $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
                self::$Connect = new \PDO($dsn, USER, PASS, null);
            endif;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        //Seta os atributos para que seja retornado as excessões do banco
        self::$Connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return  self::$Connect;
    }

    protected static function GravarLogErro($vo)
    {
        $files = PATH . 'Model/logs/logErro.txt';

        if(!file_exists($files)){
            $files = fopen($files, 'w');
        }else{
            $files = fopen($files, 'a+');
        }

        $msg = '--------------- START ---------------'. PHP_EOL;

        $msg .= 'Usuário Logado: ' . $vo->getUserLog() . PHP_EOL;
        $msg .= 'Erro técnico: ' . $vo->getErroTec() . PHP_EOL;
        $msg .= 'Data do erro: ' . $vo->getDataErro() . PHP_EOL;
        $msg .= 'Hora do erro: ' . $vo->getHoraErro() . PHP_EOL;
        $msg .= 'Função do Erro: ' . $vo->getFuncaoErro() . PHP_EOL;

        $msg .= '--------------- FINISH ---------------' . PHP_EOL . PHP_EOL;

        fwrite($files, $msg);
        fclose($files);
        
    }

    protected static function retornarConexao()
    {
        return  self::Conectar();
    }
}
