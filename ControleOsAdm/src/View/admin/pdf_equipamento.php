<?php
// Configuração do diretório utilizando o dirname(__DIR__).

use Src\Controller\EquipamentoCtrl;
use Src\public\Util;

include_once dirname(__DIR__, 2) . '/Resource/dataview/geradorPdfDataview.php';

if (isset($_POST['btn_pdf'])) {

    $tipo_filtro = (int)$_POST['tipoEqui'];
    $modelo_filtro = (int)$_POST['modeloEqui'];
    $nome_filtro = (string)$_POST['nome'];
    
    $dados = (new EquipamentoCtrl)->FiltrarEquipamentoCtrl($tipo_filtro, $modelo_filtro, $nome_filtro);

    $cabecalhos = "<center>Equipamentos encontrados</center><hr>";

   $table_inicial = "<table width='100%' style='text-align: center;'>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Identificação</th>
                <th>Situação</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>";

        $table_data = "";

             foreach ($dados as $equipamentos) { 
                $table_data .= "<tr>
                                    <td>" . $equipamentos['nome_tipo'] . "</td>
                                    <td>" . $equipamentos['nome_modelo']. "</td>
                                    <td>" . $equipamentos['identificacao']. "</td>
                                    <td>" . Util::Situacao($equipamentos['situacao']). "</td>
                                    <td>" . $equipamentos['descricao'] . "</td>
                                </tr>";
             }
             $table_data .= '</tbody></table>';

             $resultado = $cabecalhos . $table_inicial . $table_data;

    $dompdf->loadHtml($resultado);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();
}
