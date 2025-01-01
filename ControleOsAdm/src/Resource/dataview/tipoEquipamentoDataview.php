<?php
// Inclui os arquivos necessários
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

// Importa namespaces
use Src\Controller\TipoEquipamentoCtrl;
use Src\VO\TipoEquipamentoVO;

// Cria uma instância de TipoEquipamentoCtrl
$objCtrl = new TipoEquipamentoCtrl;


if (isset($_POST['btn_cadastrar'])) {
    // Cria uma nova instância de TipoEquipamentoVO
    $objVO = new TipoEquipamentoVO;

    // Define o nome do tipo de equipamento com base nos dados do formulário
    $objVO->setNomeTipo($_POST['nome_tipo']);

    // Chama o método CadastrarTipoEquipamentoCtrl para adicionar um novo tipo de equipamento
    $ret = $objCtrl->CadastrarTipoEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_cadastrar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
} 

else if (isset($_POST['detelhar_tipo_equipamento'])) {
    // Chama o método DetalharTipoEquipamentoCtrl para obter a consulta dos tipos de equipamento
    $dados = $objCtrl->DetalharTipoEquipamentoCtrl();
?>
    <!-- Exibe os cabeçalhos da tabela -->
    <thead style="text-align: center;">
        <tr>
            <th>Tipo de Equipamento</th>
            <th>Ação</th>
        </tr>
    </thead>
    <?php foreach ($dados as $tipos) { ?>
        <!-- Utiliza o laço de repetição foreach para exibir as linhas da tabela com detalhes de cada tipo de equipamento -->
        <tbody style="text-align: center;">
            <tr>
                <td><?= $tipos['nome_tipo'] ?></td>
                <td>
                    <!-- Botões para alterar e excluir tipos de equipamento (disparadores de modal) -->
                    <a href="#" data-target="#modal-alterar" data-toggle="modal" onclick="CarregarModalAlterar('<?= $tipos['id_tipo'] ?>', '<?= $tipos['nome_tipo'] ?>')" class="btn btn-warning btn-xs">Alterar</a>
                    <a href="#" data-target="#modal-excluir" data-toggle="modal" onclick="CarregarModalExcluir('<?= $tipos['id_tipo'] ?>', '<?= $tipos['nome_tipo'] ?>')" class="btn btn-danger btn-xs">Excluir</a>
                </td>
            </tr>
        </tbody>
    <?php } ?>
<?php } 

else if (isset($_POST['btn_alterar'])) {
    // Cria uma nova instância de TipoEquipamentoVO
    $objVO = new TipoEquipamentoVO;

    // Define o ID e o nome do tipo de equipamento com base nos dados do formulário
    $objVO->setIdTipo($_POST['id_alterar']);
    $objVO->setNomeTipo($_POST['nome_alterar']);

    // Chama o método AlterarTipoEquipamentoCtrl para alterar o tipo de equipamento
    $ret = $objCtrl->AlterarTipoEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_alterar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
} 
// Verifica se o formulário para excluir tipos de equipamento foi enviado
else if (isset($_POST['btn_deletar'])) {
    // Cria uma nova instância de TipoEquipamentoVO
    $objVO = new TipoEquipamentoVO;

    // Define o ID do tipo de equipamento com base nos dados do formulário
    $objVO->setIdTipo($_POST['id_excluir']);

    // Chama o método DeletarTipoEquipamentoCtrl para excluir o tipo de equipamento
    $ret = $objCtrl->DeletarTipoEquipamentoCtrl($objVO);

    // Verifica se o formulário foi enviado via AJAX
    if ($_POST['btn_deletar'] == 'ajx') {
        // Exibe o resultado
        echo $ret;
    }
}
?>
