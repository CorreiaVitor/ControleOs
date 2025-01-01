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
                            <h1 style="color: #00BFFF;">Abertura de Chamados</h1>
                            <h6>Por favor, inicie a abertura de chamados utilizando esta página.</h6>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sinta-se à vontade para abrir um chamado aqui.</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <form id="formCAD" action="<?= PAG_SELF ?>" method="post">
                                <div class="form-group">
                                    <label>Escolha o equipamento</label>
                                    <select name="equipamento" id="equipamento" class="form-control obg"></select>
                                </div>
                                <div class="form-group">
                                    <label>Descreva o problema</label>
                                    <textarea name="problema" id="problema" class="form-control obg" cols="30" rows="5" placeholder="Deixe uma descrição"></textarea>
                                </div>
                                <button type="button" name="btn_gravar" onclick="AbrirChamado('formCAD')" class="btn btn-success">Gravar</button>
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

    <script src="../../Resource/ajax/chamadoAjax.js"></script>
    <script>
        CarregarEquipamentoSetor();
    </script>
</body>

</html>