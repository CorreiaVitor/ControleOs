<?php

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Src\Public\Util;

Util::VerificarLogado();
if (isset($_GET['close']) && $_GET['close'] == 1) {
  Util::Deslogar();
}

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link" style="text-align: center;">
    <span class="brand-text font-weight-light">Administrador</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../Template/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="../../View/admin/index.php" class="d-block"><?= Util::NomeLog() ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item has-treeview">
          <a href="admin" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Administrador
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item has-treeview">
              <a href="|#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Equipamento
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../../View/admin/tipo_equipamento.php" class="nav-link">
                    <p>Tipo equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/modelo_equipamento.php" class="nav-link">
                    <p>Modelo equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/setor_equipamento.php" class="nav-link">
                    <p>Setor equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/equipamento.php" class="nav-link">
                    <p>Novo equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/consultar_equipamento.php" class="nav-link">
                    <p>Consultar equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/alocar_equipamento.php" class="nav-link">
                    <p>Alocar equipamento</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/remover_equipamento.php" class="nav-link">
                    <p>Remover equipamento</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Usuário
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../../View/admin/novo_usuario.php" class="nav-link">
                    <p>Novo usuário</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../View/admin/consultar_usuario.php" class="nav-link">
                    <p>Consultar usuários</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="../../Template/_includes/_menu.php?close=1" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Sair
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>