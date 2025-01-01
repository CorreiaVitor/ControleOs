<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/equipamentoDataview.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

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
                            <h1 style="color: #00BFFF;">Consultar Equipamento</h1>
                            <h6>Aqui você realiza a consulta dos seus equipamentos</h6>
                        </div>
                    </div>
                </div>
                <hr>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Consultar o tipo e o modelo de equipamento desejados</h3>
                    </div>
                    <div class="card-body">
                        <form action="pdf_equipamento.php" method="post">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="nome">
                                            <label for="tipoEqui">Tipo de equipamento</label>
                                            <select name="tipoEqui" id="tipoEqui" class="form-control" onchange="FiltrarEquipamentoAjax()">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modeloEqui">Modelo de equipamento</label>
                                            <select name="modeloEqui" id="modeloEqui" class="form-control" onchange="FiltrarEquipamentoAjax()">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <button name="btn_pdf" class="btn btn-primary btn-sm" >Gerar PDF</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Equipamentos cadastrados</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Alterar ou excluir equipamentos</h3>
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm" style="width: 180px;">
                                                <input autocomplete="off" type="text" name="nome" id="nome" class="form-control float-right" onkeyup="FiltrarEquipamentoAjax()" placeholder="Digite o equipamento ...">

                                                <div class="input-group-append">
                                                    <button type="submit" onclick="FiltrarEquipamentoAjax()" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover" id="tableResult">
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
        include_once 'modais/dados-descarte.php';
        ?>

        <form id="formALT" action="" method="post">
            <?php
            include_once 'modais/descarte.php';
            ?>
        </form>
    </div>

    <?php
    include_once PATH . 'Template/_includes/_scripts.php';
    ?>

    <script src="../../Resource/ajax/equipamentoAjax.js"></script>
    <script>
        CarregarModeloEquipamentoAjax();
        CarregarTipoEquipamentoAjax();
        FiltrarEquipamentoAjax();
    </script>


</body>

</html>