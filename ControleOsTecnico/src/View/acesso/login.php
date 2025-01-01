<?php
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include_once PATH . 'template/_includes/_head.php';
    ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <strong>Login</strong>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça seu login</p>

                <form id="formLOG" method="post">
                    <div class="input-group mb-3">
                        <input id="login_usuario" name="login_usuario" class="form-control obg" placeholder="CPF">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="senha_usuario" name="senha_usuario" class="form-control obg" placeholder="Digite sua senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="button" name="btn_logar" onclick="Acessar('formLOG')" class="btn btn-primary btn-block">Acessar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include_once PATH . 'template/_includes/_scripts.php';
    include_once PATH . 'template/_includes/_msg.php';
    ?>

    <script src="../../Resource/ajax/usuarioAjax.js"></script>

</body>

</html>