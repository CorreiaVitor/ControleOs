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
        include_once PATH . 'Template/_includes/_topo.php';
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 style="color: #00BFFF;">Consultar Usuário</h1>
                            <h6>Aqui você consulta todos os seus usuários</h6>
                        </div>
                    </div>
                </div>
                <hr>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aqui você consulta todos os seus usuários</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <form action="" method="POST">
                                <label>Pesquisar por usuário</label>
                                <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" onkeyup="FiltrarUsuarioAjax(this.value)" value="<?= isset($_GET['usuario']) ? $_GET['usuario'] : '' ?>" placeholder="Digite aqui o nome do usuário...">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section id="divResult" class="content" style="display: none;">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Consultar todos os usuários</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Alterar ou excluir os usuários</h3>
                                        <div class="card-tools">
                                            <!-- <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="table_search" class="form-control " placeholder="Pesquisar por ...">

                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table id="tableResult" class="table table-hover">

                                        </table>
                                    </div>
                                </div>
                            </div>
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

    <script src="../../Resource/ajax/UsuarioAjax.js"></script>
    <script>
        $(function() {
            $("#nome_usuario").focus();
        })

        FiltrarUsuarioAjax();
    </script>
</body>

</html>