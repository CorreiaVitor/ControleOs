<?php

namespace Src\public;

class Util
{
    // Inicia a sessão, caso ainda não tenha sido iniciada
    public static function IniciarSessao(): void
    {
        if (!isset($_SESSION))
            session_start();
    }

    // Cria uma nova sessão com o ID e nome do usuário
    public static function CriarSessao(int $id, string $nome): void
    {
        self::IniciarSessao();
        $_SESSION['cod'] = $id;
        $_SESSION['nome'] = $nome;
    }

    // Desloga o usuário e redireciona para a página de login
    public static function Deslogar(): void
    {
        self::IniciarSessao();
        unset($_SESSION['cod']);
        unset($_SESSION['nome']);
        self::ChamarPagina('http://localhost/ControleOs/ControleOsAdm/src/View/acesso/login');
    }

    // Verifica se o usuário está logado, caso contrário redireciona para login
    public static function VerificarLogado(): void
    {
        self::IniciarSessao();
        if (!isset($_SESSION['cod']) || empty($_SESSION['cod']))
            self::ChamarPagina('http://localhost/ControleOs/ControleOsAdm/src/View/acesso/login');
    }

    // Retorna o ID do usuário logado
    public static function UsuarioLog()
    {
        self::IniciarSessao();
        return $_SESSION['cod'];
    }

    // Retorna o nome do usuário logado
    public static function NomeLog(): string
    {
        self::IniciarSessao();
        return $_SESSION['nome'];
    }

    // Define o fuso horário para 'America/Sao_Paulo'
    public static function SetarFusoHorario(): void
    {
        date_default_timezone_set('America/Sao_paulo');
    }

    // Retorna a data atual no formato 'YYYY-MM-DD' (padrão EUA)
    public static function DataAtual(): string
    {
        self::SetarFusoHorario();
        return date('Y-m-d');
    }

    // Retorna a data atual no formato 'DD/MM/YYYY' (formato BR)
    public static function DataAtualBr(): string
    {
        self::SetarFusoHorario();
        return date('d/m/Y');
    }

    // Retorna a hora atual no formato 'HH:MM'
    public static function HoraAtual(): string
    {
        self::SetarFusoHorario();
        return date('H:i');
    }

    // Retorna a data e hora atual no formato 'YYYY-MM-DD HH:MM'
    public static function DataHoraAtual(): string
    {
        self::SetarFusoHorario();
        return date('Y-m-d H:i');
    }

    // Redireciona o usuário para uma página específica
    public static function ChamarPagina($pag)
    {
        header("location: $pag.php");
        exit;
    }

    // Remove tags HTML e converte para maiúsculas para evitar scripts maliciosos
    public static function DadosMaliciosos($palavra): string
    {
        $palavra = strip_tags($palavra);
        $palavra = mb_strtoupper($palavra, 'UTF-8');
        return $palavra;
    }

    // Remove caracteres especiais e converte para maiúsculas para evitar poluição de dados
    public static function TratarDadosGerais($palavra): string
    {
        $caracteresEspeciais = array("?", ".", ",", ";", ":", "!", "?", "-", "'", "\"", "(", ")", "[", "]", "{", "}", "+", "-", "*", "/", "=", "≠", "<", ">", "≤", "≥", "&", "%", "$", "#", "@", "~", "|", "\\", "€", "£", "¥", "¢", "$", "©", "®", "←", "→", "↑", "↓", "•", "◦", "▪", "■", "●");
        $palavra = strip_tags($palavra);
        $palavra = str_replace($caracteresEspeciais, "", trim($palavra));
        $palavra = mb_strtoupper($palavra, 'UTF-8');
        return $palavra;
    }

    // Retorna a situação de um usuário com base no código
    public static function Situacao($sit): string
    {
        switch ($sit) {
            case SITUACAO_ATIVO:
                $sit = 'ATIVO';
                break;

            default:
                $sit = 'INATIVO';
                break;
        }

        return $sit;
    }

    // Criptografa uma senha utilizando o algoritmo de hash PASSWORD_DEFAULT
    public static function CriptografarSenha($senha): string
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    // Verifica se a senha digitada corresponde ao hash da senha
    public static function VerificarSenha($senha_digitada, $senha_hash)
    {
        return password_verify($senha_digitada, $senha_hash);
    }

    // Retorna o tipo de usuário como uma string legível
    public static function TipoUsuario($tipo_usuario): string
    {
        switch ($tipo_usuario) {
            case USUARIO_ADM:
                $tipo_usuario = 'ADMINISTRADOR';
                break;
            case USUARIO_FUNCIONARIO:
                $tipo_usuario = 'FUNCIONARIO';
                break;
            case USUARIO_TECNICO:
                $tipo_usuario = 'TÉCNICO';
                break;
        }

        return $tipo_usuario;
    }

    // Cria um token JWT para autenticação de um usuário
    public static function CreateTokenAuthentication(array $dados_user)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        // Codifica o header e o payload do token
        $payload = $dados_user;
        $header = json_encode($header);
        $payload = json_encode($payload);
        $header = base64_encode($header);
        $payload = base64_encode($payload);
        
        // Cria a assinatura do token
        $sign = hash_hmac(
            "sha256",
            $header . '.' . $payload,
            SECRET_JWT,
            true
        );
        $sign = base64_encode($sign);
        
        // Retorna o token completo
        $token = $header . '.' . $payload . '.' . $sign;
        return $token;
    }

    // Verifica a autenticidade do token JWT recebido na requisição
    public static function AuthenticationTokenAccess()
    {
        $http_header = apache_request_headers();

        // Verifica se o header Authorization contém um token válido
        if (
            $http_header['Authorization'] != null &&
            str_contains($http_header['Authorization'], '.')
        ) :
            $bearer = explode(' ', $http_header['Authorization']);
            $token = explode('.', $bearer[1]);
            
            // Decompõe o token e verifica a assinatura
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];
            $valid = hash_hmac(
                'sha256',
                $header . '.' . $payload,
                SECRET_JWT,
                true
            );
            $valid = base64_encode($valid);

            // Se a assinatura for válida, retorna true
            if ($valid === $sign)
                return true;
            else
                return false;
        endif;
        return false;
    }
}
