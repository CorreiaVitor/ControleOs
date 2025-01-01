<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/setorEquipamentoDataview.php';
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
              <h1 style="color: #00BFFF;">Gerenciar Setores de Equipamentos</h1>
              <h6>Aqui você gerencia todos os setores de equipamentos cadastrados.</h6>
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
            <h3 class="card-title">Cadastre um Novo Setor de Equipamento</h3>
          </div>
          <div class="card-body">
            <form id="formID" action="setor_equipamento.php" method="post">
              <div class="form-group">
                <label>Setor</label>
                <input type="text" class="form-control obg" name="nome_setor" id="nome_setor" placeholder="Digite o setor...">
              </div>
              <button type="button" name="btn_cadastrar" onclick="CadastrarSetorEquipamentoAjax('formID')" class="btn btn-success">Gravar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <section class="content">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Aqui estão todos os Setores cadastrados.</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
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
      </section>
    </div>
    <!-- Formulário para exibição da modal de alteração de setor -->
    <form id="formALT" action="setor_equipamento.php" method="post">
      <?php include_once 'modais/alterar-setor.php'; ?>
    </form>

    <!-- Formulário para exibição da modal de exclusão de setor -->
    <form action="setor_equipamento.php" method="post">
      <?php include_once 'modais/modal-excluir.php'; ?>
    </form>

    <?php
    // Inclui o rodapé da página
    include_once PATH . 'Template/_includes/_footer.php';
    ?>

  </div>

  <?php
  // Inclui os scripts da página
  include_once PATH . 'Template/_includes/_scripts.php';
  // Inclui as mensagens da página
  include_once PATH . 'Template/_includes/_msg.php';
  ?>


  <script src="../../Resource/ajax/setorEquipamentoAjax.js"></script>
  <script>
    DetalharSetorEquipamento();
  </script>

</body>

</html>