<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a style="text-align: center;" href="../../index3.html" class="brand-link">
    <span class="brand-text font-weight-light">Funcionário</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../Template/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
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
          <a href="../../view/funcionario/meus_dados.php" class="nav-link">
            <i class="far fa-user nav-icon"></i>
            <p>Meus dados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../../view/funcionario/novo_chamado.php" class="nav-link">
            <i class="far  fas fa-pen nav-icon"></i>
            <p>Novo Chamado</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../../view/funcionario/chamados.php" class="nav-link">
            <i class="far fa-keyboard nav-icon"></i>
            <p>Chamados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../../view/funcionario/mudar_senha.php" class="nav-link">
            <i class="far  fas fa-unlock-alt nav-icon"></i>
            <p>Mudar senha</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link " onclick="Sair()">
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