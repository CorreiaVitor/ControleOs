// Amodal modal excluir será uma modal genérica
function CarregarModalExcluirJS(id, nome){
    $("#id_excluir").val(id);
    $("#nome_excluir").html(nome)
}

//A modal alterar não seré uma modal genéria

//Modal Alterar Tipo equipamento
function CarregarModalAlterarJS(id, nome){
    $("#id_alterar").val(id);
    $("#nomeTipo").val(nome);
}

//Modal Alterar Modelo equipamento
function CarregarModalAlterarModeloJS(id, nome){

    $("#id_alterar").val(id);
    $("#nome_modelo").val(nome);
}

//Modal Alterar Setor
function CarregarModalSetor(id, nome){
    $("#id_alterar").val(id);
    $("#nome_setor").val(nome);
}
//Modal Motivo Descarte
function CarregarDescarteJS(id, nome){
    $("#id_descarte").val(id);
    $("#nome_descarte").html(nome);
}

// Modal detalhes do descarte
function CarregarDescarteInfoJS(data, nome, motivo){
    $("#data_descarte_info").val(data);
    $("#nome_descarte_info").html(nome);
    $("#motivo_descarte_info").html(motivo);
}

