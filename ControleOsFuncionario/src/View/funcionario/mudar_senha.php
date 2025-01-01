<?php
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include_once PATH . 'Template/_includes/_head.php';
    include_once PATH . 'Template/_includes/_scripts.php';
    ?>
    <script>
        Verify();
    </script>
</head>

<body class="dark-mode sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper dark-mode">
        <?php
        include_once PATH . 'Template/_includes/_menu.php';
        include_once PATH . 'Template/_includes/_topo.php';
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 style="color: #00BFFF;">Mudar Senha</h1>
                            <h6>Altere sua senha aqui</h6>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Digite todos os campos</h3>
                    </div>
                    <div class="card-body">
                        <form id="formSenhaAtual" action="<? PAG_SELF ?>" method="post">
                            <div class="form-group">
                                <label>Senha atual</label>
                                <input type="password" class="form-control obg" name="senha_atual" id="senha_atual" value="" placeholder="Digite sua senha atual...">
                            </div>
                            <button type="button" class="btn btn-success" name="btn_gravar" id="btn_gravar" onclick="VerificarSenhaAtual('formSenhaAtual', 'formNovaSenha')">Confirmar</button>
                        </form>
                        <form id="formNovaSenha" class="d-none">
                            <div class="form-group">
                                <label>Nova senha</label>
                                <input type="password" class="form-control obg" name="nova_senha" id="nova_senha" value="" placeholder="Digite uma nova senha...">
                            </div>
                            <div class="form-group">
                                <label>Repetir senha</label>
                                <input type="password" class="form-control obg" name="r_senha" id="r_senha" value="" placeholder="Repetir senha...">
                            </div>
                            <button type="button" class="btn btn-success" name="btn_gravar" id="btn_gravar" onclick="MudarSenhaUsuario('formNovaSenha', 'formSenhaAtual')">Confirmar</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include_once PATH . 'Template/_includes/_footer.php';
        ?>
        <!-- /.control-sidebar -->
    </div>

    <script src="../../Resource/ajax/usuarioAjax.js"></script>
</body>

</html>