<?php

namespace Src\Resource\api\Classe;

class ApiRequest
{

    // Array que define os métodos HTTP disponíveis para a requisição.
    private $method_avaliable = ['POST'];
    private $data; // Array que armazena os dados da requisição.

    // Construtor que inicializa o array de dados.
    public function __construct()
    {
        $this->data = [];
    }

    # Métodos GET e SET para o método HTTP da requisição

    // Define o método HTTP da requisição.
    public function SetMethod($m)
    {
        $this->data['method'] = $m;
    }

    // Retorna o método HTTP da requisição.
    public function GetMethod()
    {
        return $this->data['method'];
    }

    # Métodos GET e SET para o endpoint da requisição

    // Define o endpoint da requisição.
    public function SetEndPoint($p)
    {
        $this->data['endpoint'] = $p;
    }

    // Retorna o endpoint da requisição.
    public function GetEndPoint()
    {
        return $this->data['endpoint'];
    }

    // Verifica se o método HTTP utilizado está na lista de métodos disponíveis.
    public function CheckMethod()
    {
        return in_array($this->GetMethod(), $this->method_avaliable);
    }

    // Envia a resposta da API no formato JSON e encerra a execução do script.
    public function SendResponse()
    {
        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit;
    }

    // Prepara os dados da resposta com status, mensagem e resultado, e os envia.
    public function SendData($msg = '', $result, $status)
    {
        $this->data = [
            'status' => $status, // Status da resposta (ex: sucesso ou erro).
            'message' => $msg, // Mensagem descritiva da resposta.
            'result' => $result // Resultado da operação.
        ];
        $this->SendResponse();
    }
}

?>
