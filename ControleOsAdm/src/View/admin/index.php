<?php
// Configuração do diretório utilizando o dirname(__DIR__).

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';
use Src\public\Util;
Util::VerificarLogado();
include_once dirname(__DIR__, 2) . '/Resource/dataview/inicialDataview.php';
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
                            <h1 style="color: #00BFFF;">Página inicial</h1>
                        </div>
                    </div>
                </div>
                <hr>
            </section>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações dos chamados</h3>
                    </div>
                    <div class="card-body">
                        <div id="grafico_resultado"></div>
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
    ?>

    <script src="../../Resource//ajax/UsuarioAjax.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
            google.charts.load("current", {
                packages: ['corechart']
            });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],
                ["Aguardando", <?= $dados['qtd_aguardando'] ?>, "#0E2954"],
                ["Em atendimento", <?= $dados['qtd_em_atendimento'] ?>, "#1F6E8C"],
                ["Finalizado", <?= $dados['qtd_encerrado'] ?>, "#4477CE"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Números em tempo real",
                width: 600,
                height: 400,
                bar: {
                    groupWidth: "95%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("grafico_resultado"));
            chart.draw(view, options);
        }
    </script>
</body>

</html>