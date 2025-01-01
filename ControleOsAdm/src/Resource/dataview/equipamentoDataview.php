<?php

// Configuração do diretório utilizando o dirname(__DIR__). 
// Inclui o autoload.php para carregar automaticamente as classes conforme necessário.
include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Src\Controller\EquipamentoCtrl;
use Src\Controller\ModeloEquipamentoCtrl;
use Src\Controller\SetorEquipamentoCtrl;
use Src\Controller\TipoEquipamentoCtrl;
use Src\public\Util;
use Src\VO\AlocarVO;
use Src\VO\EquipamentoVO;

// Cria uma instância do EquipamentoCtrl.
$objCtrl = new EquipamentoCtrl;

// Verifica se o botão de gravação (btn_gravar) foi pressionado via POST.
if (isset($_POST['btn_gravar'])) {

    // Cria uma instância de EquipamentoVO e popula com os dados do formulário.
    $objVO = new EquipamentoVO;

    $objVO->setIdTipo($_POST['tipoEqui']);
    $objVO->setIdModelo($_POST['modeloEqui']);
    $objVO->setIdentificacao($_POST['identificacao']);
    $objVO->setDescricao($_POST['descricao']);

    // Verifica qual botão foi pressionado no formulário (CADASTRAR || ALTERAR).
    switch ($_POST['btn_gravar']) {
        case 'Cadastrar':
            // Chama o método CadastrarEquipamentoCtrl se o botão "Cadastrar" foi pressionado.
            $ret = $objCtrl->CadastrarEquipamentoCtrl($objVO);
            break;
        default:
            // Se nenhum dos casos acima, assume que o botão é para "Alterar" e chama o método AlterarEquipamentoCtrl.
            $objVO->setIdEquipamento($_POST['id_equipamento']);
            $ret = $objCtrl->AlterarEquipamentoCtrl($objVO);
            break;
    }

    // Exibe o retorno do método (1 se bem-sucedido, -1 se houver um erro).
    echo $ret;
} else if (isset($_POST['carregar_modelo_equipamento'])) {

    // Se a requisição é para carregar modelos de equipamento via POST.

    // Cria uma instância de ModeloEquipamentoCtrl e chama o método DetalharModeloEquipamentoCtrl.
    $modelos = (new ModeloEquipamentoCtrl)->DetalharModeloEquipamentoCtrl();
    $id_modelo = isset($_POST['id_modelo']) ? $_POST['id_modelo'] : '';

?>

    <!-- Gera opções de seleção para modelos de equipamento com base nos dados recuperados. -->
    <option value="">Selecionar</option>
    <?php foreach ($modelos as $dados) { ?>
        <option <?= $id_modelo == $dados['id_modelo'] ? 'selected' : '' ?> value="<?= $dados['id_modelo'] ?>"><?= $dados['nome_modelo'] ?></option>
    <?php } ?>

<?php } else if (isset($_POST['carregar_tipo_equipamento'])) {

    // Se a requisição é para carregar tipos de equipamento via POST.

    // Cria uma instância de TipoEquipamentoCtrl e chama o método DetalharTipoEquipamentoCtrl.
    $tipos = (new TipoEquipamentoCtrl)->DetalharTipoEquipamentoCtrl();
    $id_tipo = isset($_POST['id_tipo']) ? $_POST['id_tipo'] : '';

?>

    <!-- Gera opções de seleção para tipos de equipamento com base nos dados recuperados. -->
    <option value="">Selecionar</option>
    <?php foreach ($tipos as $dados) { ?>
        <option <?= $id_tipo == $dados['id_tipo'] ? 'selected' : '' ?> value="<?= $dados['id_tipo'] ?>"><?= $dados['nome_tipo'] ?></option>
    <?php } ?>

<?php } else if (isset($_POST['carregar_setor_equipamento'])) {

    $setor = (new SetorEquipamentoCtrl)->DetalharSetorEquipamentoCtrl();

?>

    <!-- Gera opções de seleção para modelos de equipamento com base nos dados recuperados. -->
    <option value="">Selecionar</option>
    <?php foreach ($setor as $setores) { ?>
        <option value="<?= $setores['id_setor'] ?>"><?= $setores['nome_setor'] ?></option>
    <?php } ?>

<?php } else if (isset($_POST['filtrar_equipamentos'])) {

    // Se a requisição é para filtrar equipamentos via POST.

    // Obtém e sanitiza os dados do formulário.
   $tipo = (int)$_POST['tipoEqui'];
   $modelo = (int)$_POST['modeloEqui'];
   $nome = Util::DadosMaliciosos($_POST['nome']);

    // Chama o método FiltrarEquipamentoCtrl do objeto EquipamentoCtrl para obter os dados filtrados.
    $dados = $objCtrl->FiltrarEquipamentoCtrl($tipo, $modelo, $nome);

?>
    <!-- Exibe os dados filtrados em uma tabela HTML. -->
    <thead style="text-align: center;">
        <tr>
            <th>Ação</th>
            <th>Tipo</th>
            <th>Modelo</th>
            <th>Identificação</th>
            <th>Situação</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php var_dump($dados);
        foreach ($dados as $equipamentos) { ?>
            <tr>
                <td>
                    <a href="equipamento.php?id=<?= $equipamentos['id_equipamento'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                    <?php if ($equipamentos['esta_alocado'] != SITUACAO_EQUIPAMENTO_ALOCADO && $equipamentos['situacao'] != SITUACAO_DESCARTADO) { ?>
                        <a href="#" class="btn btn-secondary btn-sm" data-target="#modal-descarte" onclick="CarregarModalDescarte('<?= $equipamentos['id_equipamento'] ?>','<?= $equipamentos['nome_tipo'] . ' / ' .  $equipamentos['nome_modelo'] . ' / ' . $equipamentos['identificacao'] ?>')" data-toggle="modal">Descarte</a>
                    <?php } ?>
                    <?php if ($equipamentos['situacao'] != SITUACAO_ATIVO) { ?>
                        <a href="#" class="btn btn-primary btn-sm" data-target="#modal-dados-descarte" data-toggle="modal" onclick="CarregarModalDadosDescarte('<?= $equipamentos['nome_tipo'] . ' / ' .  $equipamentos['nome_modelo'] . ' / ' . $equipamentos['identificacao'] ?>', '<?= $equipamentos['data_descarte'] ?>', '<?= $equipamentos['motivo_descarte'] ?>')">Dados descarte</a>
                    <?php } ?>
                </td>
                <td><?= $equipamentos['nome_tipo'] ?></td>
                <td><?= $equipamentos['nome_modelo'] ?></td>
                <td><?= $equipamentos['identificacao'] ?></td>
                <td><?= Util::Situacao($equipamentos['situacao']) ?></td>
                <td><?= $equipamentos['descricao'] ?></td>
            </tr>
        <?php } ?>
    </tbody>

<?php } else if (isset($_GET['id'])) {

    // Chama o método DetalharEquipamentoCtrl do objeto EquipamentoCtrl para obter os detalhes do equipamento.
    $equipamentos = $objCtrl->DetalharEquipamentoCtrl(Util::DadosMaliciosos($_GET['id']));
    // Redireciona para a página de consulta de equipamentos se não houver equipamentos com o ID fornecido.
    if (!is_array($equipamentos) || !is_numeric($_GET['id'])) {
        header("location: consultar_equipamento.php");
        exit;
    }
} else if (isset($_POST['btn_descarte'])) {

    $objVO = new EquipamentoVO;

    $objVO->setIdEquipamento($_POST['id_equipamento']);
    $objVO->setMotivoDescarte($_POST['motivo_descarte']);
    $objVO->setDataDescarte($_POST['data_descarte']);

    $ret = $objCtrl->DescartarEquipamentoCtrl($objVO);

    echo $ret;
} else if (isset($_POST['consultar_equipamento_nao_alocado'])) {

    $dadosEqui = $objCtrl->ConsultarEquipamentoNaoAlocadoCtrl();

?>

    <option value="">Selecionar</option>
    <?php foreach ($dadosEqui as $equipamento) { ?>
        <option value="<?= $equipamento['id_equipamento'] ?>"><?= $equipamento['nome_tipo'] . ' / ' . $equipamento['nome_modelo'] . ' / IDENTIFICAÇÃO: ' . $equipamento['identificacao'] ?></option>
    <?php } ?>

<?php } else if (isset($_POST['btn_alocar'])) {

    $objVO = new AlocarVO;

    $objVO->setEquipamentoId($_POST['equipamento']);
    $objVO->setSetorId($_POST['setor']);

    $ret = $objCtrl->AlocarEquipamentoCtrl($objVO);

    echo $ret;
} else if (isset($_POST['equipamento_alocado_setor'])) {

    $dados = $objCtrl->EquipamentoAlocadoSetorCtrl($_POST['setor']);

?>

    <!-- Exibe os dados filtrados em uma tabela HTML. -->
    <thead style="text-align: center;">
        <tr>
            <th>Ação</th>
            <th>Equipamento</th>
            <th>Alocado em</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php foreach ($dados as $setores) { ?>
            <tr>
                <td><a href="#" class="btn btn-danger btn-sm" data-target="#modal-excluir" data-toggle="modal" onclick="CarregarModalExcluir('<?= $setores['id_alocar'] ?>', '<?= 'Identificação: ' . $setores['identificacao'] . ' / ' . $setores['nome_tipo'] . ' / ' . $setores['nome_modelo'] ?>')">Remover do setor</a></a></td>
                <td><?= 'Identificação: ' . $setores['identificacao'] . ' / ' . $setores['nome_tipo'] . ' / ' . $setores['nome_modelo'] ?></td>
                <td><?= $setores['data_alocar'] ?></td>
            </tr>
        <?php } ?>
    </tbody>

<?php } else if (isset($_POST['btn_deletar'])) {

    $objVO = new AlocarVO;

    $objVO->setId($_POST['id_excluir']);

    $ret = $objCtrl->RemoverEquipamentoAlocadoCtrl($objVO);
    echo $ret;
} ?>