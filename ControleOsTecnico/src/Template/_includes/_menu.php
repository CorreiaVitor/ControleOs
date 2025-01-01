<?php

// include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
// use Src\Public\Util;

// Util::VerificarLogado();
// if(isset($_GET['close']) && $_GET['close'] == 1){
//   Util::Deslogar();
// }

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="../../index3.html" class="brand-link">
    <img src="../../template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Técnico</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../template/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block" id="nome_logado"></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="../../view/tecnico/meus_dados.php" class="nav-link">
            <i class="far fa-user nav-icon"></i>
            <p>Meus dados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../../view/tecnico/chamados.php" class="nav-link">
            <i class="far fa-keyboard nav-icon"></i>
            <p>Chamados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../../view/tecnico/mudar_senha.php" class="nav-link">
            <i class="far  fas fa-unlock-alt nav-icon"></i>
            <p>Mudar senha</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" onclick="Sair()" class="nav-link">
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
<script>
  MostrarNomeLogin();
</script>