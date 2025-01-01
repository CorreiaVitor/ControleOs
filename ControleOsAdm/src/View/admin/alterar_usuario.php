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
                            <h1 style="color: #00BFFF;">Alterar usuário</h1>
                            <h6>Aqui você pode alterar um usuário</h6>
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
                                <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $dados['id_usuario'] ?>">
                                <input type="hidden" name="id_endereco" id="id_endereco" value="<?= $dados['id_endereco'] ?>">
                                <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?= $dados['tipo_usuario'] ?>">
                                <div class="form-group">
                                    <label>Tipo de usuário: <span style="color: #3795BD;"><?= isset($dados) ? Util::TipoUsuario($dados['tipo_usuario']) : '' ?></span></label>
                                </div>
                                <div id="divDadosUsuario">
                                    <div class="row">
                                        <div class="form-group col-md-9">
                                            <label>Nome</label>
                                            <input autocomplete="off" type="text" class="form-control obg" name="nome" id="nome" value="<?= isset($dados) ? $dados['nome_usuario'] : '' ?>" placeholder="Digite aqui o seu nome...">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Telefone</label>
                                            <input autocomplete="off" type="tel" class="form-control obg tel num" name="telefone" id="telefone" value="<?= isset($dados) ? $dados['tel_usuario'] : '' ?>" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>CPF</label>
                                            <input autocomplete="off" type="email" class="form-control obg cpf num" onblur="ValidarCpf(this.value)" name="cpf" id="cpf" value="<?= isset($dados) ? $dados['cpf_usuario'] : '' ?>" placeholder="Digite aqui o seu cpf...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>E-mail</label>
                                            <input autocomplete="off" type="email" class="form-control obg" name="email" id="email" value="<?= isset($dados) ? $dados['email_usuario'] : '' ?>" onblur="VerificarEmailCadastrado(this.value)" placeholder="Digite aqui o seu email...">
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($dados) ? $dados['tipo_usuario'] == USUARIO_FUNCIONARIO : '') { ?>
                                    <div class="form-group">
                                        <label>Setor</label>
                                        <input type="hidden" id="id_setor" value="<?= $dados['setor_id'] ?>">
                                        <select name="setor" id="setor" class="form-control">
                                            <?php for($i = 0; count($setor) > $i; $i++) { ?>
                                                <option <?= $dados['setor_id'] == $setor[$i]['id_setor'] ? 'selected' : '' ?> value="<?= $setor[$i]['id_setor'] ?>"><?= $setor[$i]['nome_setor'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <?php if (isset($dados) ? $dados['tipo_usuario'] == USUARIO_TECNICO : '') { ?>
                                    <div class="form-group">
                                        <label>Empresa</label>
                                        <input autocomplete="off" type="tel" class="form-control" name="empresa" id="empresa" value="<?= isset($dados) ? $dados['nome_empresa'] : '' ?>" placeholder="Digite aqui o nome da empresa...">
                                    </div>
                                <?php } ?>
                                <div id="divDadosEndereco">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input autocomplete="off" type="text" class="form-control obg cep num" name="cep" id="cep" value="<?= isset($dados) ? $dados['cep'] : '' ?>" onblur="pesquisaCep(this.value)" placeholder="Digite aqui o cep...">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Rua</label>
                                            <input type="text" disabled class="form-control obg" name="rua" id="rua" value="<?= isset($dados) ? $dados['rua'] : '' ?>" placeholder="Digite aqui a rua...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Bairro</label>
                                            <input type="text" disabled class="form-control obg" name="bairro" id="bairro" value="<?= isset($dados) ? $dados['bairro'] : '' ?>" placeholder="Digite aqui o bairro...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Estado</label>
                                            <input type="text" disabled class="form-control obg" name="estado" id="estado" value="<?= isset($dados) ? $dados['sigla_estado'] : '' ?>" placeholder="Digite aqui o estado (PREENCHIMENTO AUTOMÁTICO)...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Cidade</label>
                                            <input type="text" disabled class="form-control obg" name="cidade" id="cidade" value="<?= isset($dados) ? $dados['nome_cidade'] : '' ?>" placeholder="Digite aqui a cidade (PREENCHIMENTO AUTOMÁTICO)...">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btn_cadastrar" onclick="AlterarUsuarioAjax('formUser')" class="btn btn-success">Alterar</button>
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
    <script src="../../Resource/ajax/UsuarioAjax.js"></script>

</body>

</html>