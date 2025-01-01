<?php

// Inclui o autoloader gerado pelo Composer para carregar as dependências
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

// Importa a classe FuncionarioEndPoints
use Src\Resource\api\Classe\FuncionarioEndPoints;

// Instancia o objeto da classe FuncionarioEndPoints
$obj = new FuncionarioEndPoints();

// Define o método HTTP (GET, POST, etc.) da requisição
$obj->SetMethod($_SERVER['REQUEST_METHOD']);

// Verifica se o método HTTP é válido
if (!$obj->CheckMethod()) {
    // Retorna uma mensagem de erro se o método não for aceito
    $obj->SendData('METHOD INVÁLIDO', "-1", "ERRO");
}

// Obtém os cabeçalhos da requisição
$recebido = getallheaders();

// Verifica se o conteúdo da requisição é do tipo JSON
$json = $recebido['Content-Type'] == 'application/json' ? true : false;

// Processa os dados recebidos com base no tipo de conteúdo
if ($json) {
    // Caso o conteúdo seja JSON, decodifica os dados
    $dados = file_get_contents('php://input');
    $dados = json_decode($dados, true);
} else {
    // Caso contrário, utiliza os dados enviados via formulário
    $dados = $_POST;
}

// Define o endpoint solicitado nos dados recebidos
$obj->SetEndPoint($dados['endpoint']);

// Verifica se o endpoint existe na classe
if (!$obj->CheckEndPoint($obj->GetEndPoint())) {
    // Retorna uma mensagem de erro se o endpoint for inválido
    $obj->SendData("ENDPOINT INVALIDO", "-1", "ERRO");
}

// Adiciona os parâmetros recebidos à classe
$obj->AddParameters($dados);

// Chama o método correspondente ao endpoint solicitado
$result = $obj->{$obj->GetEndPoint()}();

// Envia a resposta com o resultado do processamento
$obj->SendData("RESULTADO", $result, "SUCESSO");

?>
