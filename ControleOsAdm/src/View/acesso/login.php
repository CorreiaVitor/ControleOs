<?php

include_once dirname(__DIR__, 2) . '/Resource/dataview/usuarioDataview.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once PATH . 'Template/_includes/_head.php';
    ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <strong>Controle de chamados</strong>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça seu Login</p>
                <form id="formLOG" action="" method="post">
                    <div class="input-group mb-3">
                        <input id="login_usuario" name="login_usuario" type="text" class="form-control obg" placeholder="CPF">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="senha_usuario" name="senha_usuario" type="password" class="form-control obg" placeholder="Digite sua senha senha...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-4">
                            <button type="submit" name="btn_logar" onclick="return validarCamposJS('formLOG')" class="btn btn-success btn-block">Acessar</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>


    <?php
    include_once PATH . 'Template/_includes/_scripts.php';
    include_once PATH . 'Template/_includes/_msg.php';
    ?>
    <script src="../../Resource/ajax/UsuarioAjax.js"></script>
</body>

</html>