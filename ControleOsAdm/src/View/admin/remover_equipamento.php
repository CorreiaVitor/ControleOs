<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/equipamentoDataview.php';

?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include_once PATH . 'Template/_includes/_head.php';
    ?>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
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
                            <h1 style="color: #00BFFF;">Remover equipamento</h1>
                            <h6>Aqui você poderá remover seus equipamentos</h6>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aqui você consulta todos os seus usuarios</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <form action="remover_equipamento.php" method="post">
                                <label>Selecione o setor</label>
                                <select name="setor" id="setor" class="form-control" onchange="EquipamentoAlocadoSetorAjax()">

                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="card" id="divResultado" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Consultar todos os equipamentos deste setor</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Lista de equipamento</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table id="tableResults" class="table table-hover">

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

        <?php
            include_once 'modais/modal-excluir.php';
        ?>

    </div>
    <?php
    include_once PATH . 'Template/_includes/_msg.php';
    include_once PATH . 'Template/_includes/_scripts.php';
    ?>

    <script src="../../Resource/ajax/setorEquipamentoAjax.js"></script>
    <script src="../../Resource/ajax/equipamentoAjax.js"></script>
    <script>
        CarregarSetorEquipamentoAjax();
    </script>

</body>

</html>