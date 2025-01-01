<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/modeloEquipamentoDataview.php';
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
              <h1 style="color: #00BFFF;">Gerenciar Modelos de Equipamentos</h1>
              <h6>Aqui você gerencia os modelos de equipamentos cadastrados</h6>
            </div>
          </div>
        </div>
        <hr>
      </section>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Cadastrar um Novo Modelo de Equipamento</h3>
          </div>
          <div class="card-body">
            <form id="formID" action="gerenciar_modeloequipamento.php" method="post">
              <div class="form-group">
                <label>Modelo</label>
                <input type="text" class="form-control obg" name="nome_modelo" id="nome_modelo" placeholder="Digite o modelo do equipamento ... ">
              </div>
              <button type="button" name="btn_cadastrar" onclick="CadastrarModeloEquipamentoAjax('formID')" class="btn btn-success">Gravar</button>
            </form>
          </div>
        </div>
        <section class="content">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Aqui estão todos os Modelos cadastrados.</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover" id="tableResult">
                        <!-- Conteúdo da tabela -->
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

    <!-- Formulário responsável pela exibição da modal de alteração -->
    <form id="formALT" action="modelo_equipamento.php" method="post">
      <?php include_once 'modais/alterar-modelo.php'; ?>
    </form>

    <!-- Formulário responsável pela exibição da modal de exclusão -->
    <form action="modelo_equipamento.php" method="post">
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

  <script src="../../Resource/ajax/modeloEquipamentoAjax.js"></script>
  <script>
    DetalharModeloEquipamento();
  </script>
</body>

</html>