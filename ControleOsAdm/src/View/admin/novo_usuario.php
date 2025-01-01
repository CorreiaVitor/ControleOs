<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/usuarioDataview.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include_once PATH . 'Template/_includes/_head.php';
    ?>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper dark-mode">

        <?php
        include_once PATH . 'Template/_includes/_menu.php';
        include_once PATH . 'Template/_includes/_topo.php'
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 style="color: #00BFFF;">Novo usuário</h1>
                            <h6>Aqui você insere um novo usuário</h6>
                        </div>
                    </div>
                </div>
                <hr>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <form id="formUser" action="" method="post">
                                <div class="form-group">
                                    <label>Escolha o tipo de usuário</label>
                                    <select name="tipo_usuario" id="tipo_usuario" onchange="CarregarCamposUsuarioJS(this.value)" class="form-control obg">
                                        <option value="0">Selecionar</option>
                                        <option value="<?= USUARIO_ADM ?>">Administrador</option>
                                        <option value="<?= USUARIO_FUNCIONARIO ?>">Funcionario</option>
                                        <option value="<?= USUARIO_TECNICO ?>">Técnico</option>
                                    </select>
                                </div>
                                <div id="divDadosUsuario" style="display: none;">
                                    <div class="row">
                                        <div class="form-group col-md-9">
                                            <label>Nome</label>
                                            <input autocomplete="off" type="text" class="form-control obg" name="nome" id="nome" value="" placeholder="Digite aqui o seu nome...">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Telefone</label>
                                            <input autocomplete="off" type="text" class="form-control obg tel num" name="telefone" id="telefone" value="" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>CPF</label>
                                            <input autocomplete="off" type="text" class="form-control obg cpf num" onblur="VerificarCpfCadastrado(this.value)" name="cpf" id="cpf" value="" placeholder="Digite aqui o seu cpf...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>E-mail</label>
                                            <input autocomplete="off" type="email" class="form-control obg" name="email" id="email" onblur="VerificarEmailCadastrado(this.value)" placeholder="Digite aqui o seu email...">
                                        </div>
                                    </div>
                                </div>
                                <div id="divUsuarioFuncionario" style="display: none;">
                                    <div class="form-group">
                                        <label>Setor</label>
                                        <select name="setor" id="setor" class="form-control">
                                            <option value="0">Selecionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="divUsuarioTecnico" style="display: none;">
                                    <div class="form-group">
                                        <label>Empresa</label>
                                        <input autocomplete="off" type="tel" class="form-control" name="empresa" id="empresa" value="" placeholder="Digite aqui o nome da empresa...">
                                    </div>
                                </div>
                                <div id="divDadosEndereco" style="display: none;">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input autocomplete="off" type="text" class="form-control obg cep num" name="cep" id="cep" onblur="pesquisaCep(this.value)" placeholder="Digite aqui o cep...">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Rua</label>
                                            <input autocomplete="off" type="text" class="form-control obg" name="rua" id="rua" value="" placeholder="Digite aqui a rua...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Bairro</label>
                                            <input autocomplete="off" type="text" class="form-control obg" name="bairro" id="bairro" value="" placeholder="Digite aqui o bairro...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Estado</label>
                                            <input type="text" class="form-control obg" name="estado" id="estado" value="" placeholder="Digite aqui o estado (PREENCHIMENTO AUTOMÁTICO)...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Cidade</label>
                                            <input type="text" class="form-control obg" name="cidade" id="cidade" value="" placeholder="Digite aqui a cidade (PREENCHIMENTO AUTOMÁTICO)...">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btn_cadastrar" onclick="CadastrarUsuarioAjax('formUser')" style="display: none;" class="btn btn-success">Gravar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include_once PATH . 'Template/_includes/_footer.php';
        ?>
    </div>
    <?php
    include_once PATH . 'Template/_includes/_scripts.php';
    ?>

    <script src="../../Resource/js/buscar_cep.js"></script>
    <script src="../../Resource/js/funcoes.js"></script>
    <script src="../../Template/mask/jquery.mask.min.js"></script>
    <script src="../../Template/mask/mask.js"></script>
    <script src="../../Resource//ajax/UsuarioAjax.js"></script>
    <script src="../../Resource//ajax/equipamentoAjax.js"></script>

    <script>
        CarregarSetorEquipamentoAjax()
    </script>
</body>

</html>