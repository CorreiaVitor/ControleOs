// Função em JavaScript para carregar dados em um modal de alteração
function CarregarModalAlterar(id, nome) {

    // Define o valor do campo 'id_alterar' no modal com o ID fornecido
    $("#id_alterar").val(id);

    // Define o valor do campo 'nome_alterar' no modal com o nome fornecido
    $("#nome_alterar").val(nome);

}

// Função em JavaScript para carregar dados em um modal de exclusão
function CarregarModalExcluir(id, nome)
{
    // Atualiza o valor do campo de input com o id "id_excluir" com o valor passado como parâmetro
    $("#id_excluir").val(id);

    // Atualiza o conteúdo HTML do elemento com o id "nome_excluir" com o valor passado como parâmetro
    $("#nome_excluir").html(nome);
}

function CarregarModalDescarte(id, equipamento) {
    $("#id_equipamento").val(id);
    $("#nome_equipamentos").html(equipamento);
}

function CarregarModalDadosDescarte(info, data, motivo) {
    $("#infoEquipamento").html(info);
    $("#dataDescarte").val(data);
    $("#motivoDescarte").val(motivo);
}


