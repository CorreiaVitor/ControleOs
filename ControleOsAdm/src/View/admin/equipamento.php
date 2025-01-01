<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/equipamentoDataview.php';

$titulo = isset($equipamentos) ? EQUIPAMENTO_ALTERAR : EQUIPAMENTO_CADASTRAR;
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
                            <h1 style="color: #00BFFF;"><?= $titulo ?> Equipamento</h1>
                        </div>
                    </div>
                </div>
                <hr>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <form id="formID" action="equipamento.php" method="post">
                            <div class="form-group">
                                <label>Tipo de equipamento</label>
                                 <input type="hidden" name="id_equipamento" id="id_equipamento" value="<?= isset($equipamentos) ? $equipamentos['id_equipamento'] : '' ?>">
                                 <input type="hidden" name="id_tipo" id="id_tipo" value="<?= isset($equipamentos) ? $equipamentos['tipo_id'] : '' ?>">
                                <select name="tipoEqui" id="tipoEqui" class="form-control obg">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Modelo de equipamento</label>
                                <input type="hidden" name="id_modelo" id="id_modelo" value="<?= isset($equipamentos) ? $equipamentos['modelo_id'] : '' ?>">
                                <select name="modeloEqui" id="modeloEqui" class="form-control obg">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Identificação</label>
                                <input type="text" class="form-control obg" name="identificacao" id="identificacao" value="<?= isset($equipamentos) ? $equipamentos['identificacao'] : '' ?>" placeholder="Digite a identificação...">
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control obg" maxlength="100" cols="30" rows="2" placeholder="Deixe uma descrição"><?= isset($equipamentos) ? $equipamentos['descricao'] : '' ?></textarea>
                            </div>
                            <button type="button" id="btn_gravar" onclick="GravarEquipamentoAjax('formID')" class="btn btn-success"><?= $titulo ?></button>
                        </form>
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
    include_once PATH . 'Template/_includes/_msg.php';
    ?>

    <script src="../../Resource/ajax/equipamentoAjax.js"></script>
    <script>
        CarregarModeloEquipamentoAjax();
        CarregarTipoEquipamentoAjax();
    </script>
</body>

</html>