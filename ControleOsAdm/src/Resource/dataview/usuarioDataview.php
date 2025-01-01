<?php

// Configuração do diretório utilizando o dirname(__DIR__) para localizar o autoloader do Composer.
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

// Importação de classes necessárias para o funcionamento do script
use Src\Controller\UsuarioCtrl;
use Src\public\Util;
use Src\VO\FuncionarioVO;
use Src\VO\TecnicoVO;
use Src\VO\UsuarioVO;
use Src\Controller\SetorEquipamentoCtrl;

// Instancia o controlador de usuários
$objCtrl = new UsuarioCtrl();

// Verifica se o email informado já está cadastrado
if (isset($_POST['verificar_email_cadastrado'])) {

    echo $ret = $objCtrl->VerificarEmailCadastradoCtrl($_POST['email']);

// Verifica se o CPF informado já está cadastrado
} else if (isset($_POST['verificar_cpf_cadastrado'])) {

    echo $ret = $objCtrl->VerificarCpfCadastradoCtrl($_POST['cpf']);

// Realiza o cadastro de um novo usuário
} else if (isset($_POST['btn_cadastrar'])) {

    // Determina o tipo de usuário com base na entrada do formulário
    switch ($_POST['tipo_usuario']) {

        case USUARIO_ADM:
            // Cria um objeto do tipo UsuarioVO para Administrador
            $objVO = new UsuarioVO;
            break;

        case USUARIO_TECNICO:
            // Cria um objeto do tipo TecnicoVO
            $objVO = new TecnicoVO;

            // Adiciona os dados específicos do Técnico
            $objVO->setNomeEmpresa($_POST['empresa']);
            break;

        case USUARIO_FUNCIONARIO:
            // Cria um objeto do tipo FuncionarioVO
            $objVO = new FuncionarioVO;

            // Adiciona os dados específicos do Funcionário
            $objVO->setIdsetor($_POST['setor']);
            break;
    }

    // Adiciona os dados comuns a todos os tipos de usuário
    $objVO->setTipoUsuario($_POST['tipo_usuario']);
    $objVO->setNome($_POST['nome']);
    $objVO->setEmail($_POST['email']);
    $objVO->setCpf($_POST['cpf']);
    $objVO->setTelefone($_POST['telefone']);

    // Adiciona os dados de endereço
    $objVO->setRua($_POST['rua']);
    $objVO->setBairro($_POST['bairro']);
    $objVO->setCep($_POST['cep']);
    $objVO->setCidade($_POST['cidade']);
    $objVO->setEstado($_POST['estado']);

    // Chama o método para realizar o cadastro e retorna o resultado
    echo $ret = $objCtrl->CadastrarUsuarioCtrl($objVO);

// Consulta usuários com base no nome fornecido
} else if (isset($_POST['consultar_usuario'])) {

    $dados = $objCtrl->FiltrarUsuarioCtrl($_POST['nome_usuario']);

?>

    <!-- Cabeçalho da tabela de exibição de usuários -->
    <thead align="center">
        <tr>
            <th>Ação</th>
            <th></th>
            <th>Nome</th>
            <th>Tipo</th>
        </tr>
    </thead>
    <tbody align="center">
        <!-- Loop pelos usuários encontrados -->
        <?php foreach ($dados as $usuario) {

            $situacao = $usuario['status_usuario'];

        ?>
            <tr>
                <!-- Botão para alterar o usuário -->
                <td>
                    <a href="alterar_usuario.php?cod=<?= $usuario['id_usuario'] ?>" class="btn btn-warning btn-xm">Alterar</a>
                </td>

                <!-- Controle para ativar ou inativar o usuário -->
                <td>
                    <div class="custom-control custom-switch custom-switch-<?= $situacao == USUARIO_ATIVO ? 'off' : 'on' ?>-success custom-switch-<?= $situacao == USUARIO_ATIVO ?  'on' : 'off' ?>-danger">
                        <input onclick="InativarUsuarioAjax('<?= $usuario['id_usuario'] ?>', '<?= $situacao ?>')" type="checkbox" class="custom-control-input" id="customSwitch<?= $usuario['id_usuario'] ?>">
                        <label class="custom-control-label" for="customSwitch<?= $usuario['id_usuario'] ?>"><?= Util::Situacao($situacao) ?></label>
                    </div>
                </td>

                <!-- Exibe o nome e o tipo do usuário -->
                <td><?= $usuario['nome_usuario'] ?></td>
                <td><?= Util::TipoUsuario($usuario['tipo_usuario']) ?></td>
            </tr>
        <?php } ?>
    </tbody>

<?php 

// Atualização de dados do usuário
} else if (isset($_POST['btn_alterar'])) {

    // Determina o tipo de usuário com base na entrada do formulário
    switch ($_POST['tipo_usuario']) {

        case USUARIO_ADM:
            // Cria um objeto do tipo UsuarioVO para Administrador
            $objVO = new UsuarioVO;
            break;

        case USUARIO_TECNICO:
            // Cria um objeto do tipo TecnicoVO
            $objVO = new TecnicoVO;

            // Adiciona os dados específicos do Técnico
            $objVO->setNomeEmpresa($_POST['empresa']);
            break;

        case USUARIO_FUNCIONARIO:
            // Cria um objeto do tipo FuncionarioVO
            $objVO = new FuncionarioVO;

            // Adiciona os dados específicos do Funcionário
            $objVO->setIdsetor($_POST['setor']);
            break;
    }

    // Adiciona os dados comuns a todos os tipos de usuário
    $objVO->setId($_POST['id_usuario']);
    $objVO->setTipoUsuario($_POST['tipo_usuario']);
    $objVO->setNome($_POST['nome']);
    $objVO->setEmail($_POST['email']);
    $objVO->setCpf($_POST['cpf']);
    $objVO->setTelefone($_POST['telefone']);

    // Adiciona os dados de endereço
    $objVO->setEnderecoId($_POST['id_endereco']);
    $objVO->setRua($_POST['rua']);
    $objVO->setBairro($_POST['bairro']);
    $objVO->setCep($_POST['cep']);
    $objVO->setCidade($_POST['cidade']);
    $objVO->setEstado($_POST['estado']);

    // Chama o método para alterar os dados do usuário e retorna o resultado
    echo $ret = $objCtrl->AlterarUsuarioCtrl($objVO);

// Inativação de um usuário
} else if (isset($_POST['inativar_usuario'])) {

    // Cria um objeto do tipo UsuarioVO
    $objVO = new UsuarioVO;

    // Adiciona os dados de ID e status do usuário
    $objVO->setId($_POST['id_usuario']);
    $objVO->setStatus($_POST['status_usuario']);

    // Chama o método para inativar o usuário e retorna o resultado
    echo $objCtrl->InativarUsuarioCtrl($objVO);

// Detalhamento de um usuário específico
} else if (isset($_GET['cod']) && is_numeric($_GET['cod'])) {

    // Busca os dados detalhados do usuário
    $dados = $objCtrl->DetalharUsuarioCtrl($_GET['cod']);

    // Redireciona se os dados não forem encontrados
    if (!is_array($dados) || empty($dados))
        Util::ChamarPagina('consultar_usuario');

    // Caso o usuário seja um funcionário, busca o setor correspondente
    if ($dados['tipo_usuario'] == USUARIO_FUNCIONARIO)
        $setor = (new SetorEquipamentoCtrl)->DetalharSetorEquipamentoCtrl();

// Validação de login
} else if (isset($_POST['btn_logar'])) {

    // Coleta as credenciais do formulário
    $login = $_POST['login_usuario'];
    $senha = $_POST['senha_usuario'];

    // Chama o método de validação de login
    $ret = $objCtrl->ValidarLoginCtrl($login, $senha);
}

?>
