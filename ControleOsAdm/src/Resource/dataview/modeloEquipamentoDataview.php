<?php
// Inclui os arquivos necessários
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

// Importa namespaces
use Src\Controller\ModeloEquipamentoCtrl;
use Src\VO\ModeloEquipamentoVO;

// Cria uma instância de modeloEquipamentoCtrl
$objCtrl = new ModeloEquipamentoCtrl;


if (isset($_POST['btn_cadastrar'])) {
    // Cria uma nova instância de modeloEquipamentoVO
    $objVO = new ModeloEquipamentoVO;

    // Define o nome do modelo de equipamento com base nos dados do formulário
    $objVO->setNomeModelo($_POST['nome_modelo']);

    // Chama o método CadastrarModeloEquipamentoCtrl para adicionar um novo modelo de equipamento
    $ret = $objCtrl->CadastrarModeloEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_cadastrar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
} 

else if (isset($_POST['detelhar_modelo_equipamento'])) {
    // Chama o método DetalharModeloEquipamentoCtrl para obter a consulta dos modelos de equipamento
    $dados = $objCtrl->DetalharModeloEquipamentoCtrl();
?>
    <!-- Exibe os cabeçalhos da tabela -->
    <thead style="text-align: center;">
        <tr>
            <th>Modelo de Equipamentos</th>
            <th>Ação</th>
        </tr>
    </thead>
    <?php foreach ($dados as $modelos) { ?>
        <!-- Utiliza o laço de repetição foreach para exibir as linhas da tabela com detalhes de cada modelo de equipamento -->
        <tbody style="text-align: center;">
            <tr>
                <td><?= $modelos['nome_modelo'] ?></td>
                <td>
                    <!-- Botões para alterar e excluir modelos de equipamentos (disparadores de modal) -->
                    <a href="#" data-target="#modal-alterar" data-toggle="modal" onclick="CarregarModalAlterar('<?= $modelos['id_modelo'] ?>', '<?= $modelos['nome_modelo'] ?>')" class="btn btn-warning btn-xs">Alterar</a>
                    <a href="#" data-target="#modal-excluir" data-toggle="modal" onclick="CarregarModalExcluir('<?= $modelos['id_modelo'] ?>', '<?= $modelos['nome_modelo'] ?>')" class="btn btn-danger btn-xs">Excluir</a>
                </td>
            </tr>
        </tbody>
    <?php } ?>
<?php } 

else if (isset($_POST['btn_alterar'])) {
    // Cria uma nova instância de modeloEquipamentoVO
    $objVO = new ModeloEquipamentoVO;

    // Define o ID e o nome do modelo de equipamento com base nos dados do formulário
    $objVO->setIdModelo($_POST['id_alterar']);
    $objVO->setNomeModelo($_POST['nome_alterar']);

    // Chama o método AlterarModeloEquipamentoCtrl para alterar o modelo de equipamento
    $ret = $objCtrl->AlterarModeloEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_alterar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
} 
// Verifica se o formulário para excluir modelos de equipamento foi enviado
else if (isset($_POST['btn_deletar'])) {
    // Cria uma nova instância de modeloEquipamentoVO
    $objVO = new ModeloEquipamentoVO;

    // Define o ID do modelo de equipamento com base nos dados do formulário
    $objVO->setIdModelo($_POST['id_excluir']);

    // Chama o método DeletarModeloEquipamentoCtrl para excluir o modelo de equipamento
    $ret = $objCtrl->DeletarModeloEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_deletar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
}
?>
