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
  include_once PATH . 'Template/_includes/_head.php'
  ?>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <!-- Site wrapper -->
  <div class="wrapper dark-mode">
    <!-- Navbar -->
    <?php
    include_once PATH . 'Template/_includes/_menu.php';
    include_once PATH . 'Template/_includes/_topo.php';
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h2 style="color: #00BFFF;">Alocar equipamento</h2>
              <h6>Aqui, você realiza a alocação de um equipamento para um setor específico.</h6>
            </div>
          </div>
        </div>
        <hr>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Selecione os equipamentos que deseja alocar e indique o setor de destino</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <form id="formCAD" action="alocar_equipamento.php" method="post">
                    <div class="form-group">
                      <label>Equipamentos</label>
                      <select name="equipamento" id="equipamento" class="form-control obg" style="width: 100%;">
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Setores</label>
                      <select name="setor" id="setor" class="form-control obg" style="width: 100%;">
                      </select>
                    </div>
                    <button type="button" name="btn_alocar" onclick="AlocarEquipamentoAjax('formCAD')" class="btn btn-success">Alocar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php
    include_once PATH . 'Template/_includes/_footer.php'
    ?>

  </div>

  <?php
  include_once PATH . 'Template/_includes/_scripts.php';
  include_once PATH . 'Template/_includes/_msg.php';
  ?>

  <script src="../../Resource/ajax/equipamentoAjax.js"></script>
  <script src="../../Resource/ajax/setorEquipamentoAjax.js"></script>
  <script>
    CarregarSetorEquipamentoAjax();
    ConsultarEquipamentoNaoAlocadoAjax();
  </script>

</body>

</html>