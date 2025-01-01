
// Função em JavaScript para obter e exibir detalhes de setors de equipamento via AJAX
function DetalharSetorEquipamento() {
    
    // Envia uma requisição AJAX para obter detalhes de setors de equipamento
    $.ajax({

        // Antes de enviar a requisição, exibe o indicador de carregamento
        beforeSend: function(){
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('setorEquipamentoDataview'),
        data: {
            detelhar_setor_equipamento: '',
            carregar: $("#carregar").val()
           
        },
        // Ao receber uma resposta bem-sucedida, atualiza a tabela com os dados obtidos
        success: function (dados){

            $("#tableResult").html(dados);
            $("#setor").html(dados);
            
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function(){
            RemoverLoad();
        }

    });

}

// Função em JavaScript para cadastrar um novo setor de equipamento via AJAX
function CadastrarSetorEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if(validarCamposJS(formID)){

        // Obtém o valor do campo 'nome_setor' do formulário
        let nome = $("#nome_setor").val();

        // Envia uma requisição AJAX para cadastrar o setor de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function(){
                Load();
            },
            type: 'post',
            url: BASE_URL_DATAVIEW('setorEquipamentoDataview'),
            data: {
                btn_cadastrar: 'ajx',
                nome_setor: nome
            },
            // Ao receber uma resposta bem-sucedida
            success: function (ret){
                console.log(ret);
                // Exibe mensagens de retorno
                mensagensJS(ret);
                // Limpa os campos do formulário
                LimparCamposJS(formID);
                // Atualiza os detalhes do setor de equipamento na tabela
                DetalharSetorEquipamento();
            },
            // Ao completar a requisição, remove o indicador de carregamento
            complete: function(){
                RemoverLoad();
            }

        });

    }
    
}

function AlterarSetorEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if (validarCamposJS(formID)) {

        // Obtém o valor do campo 'nome_altera' do formulário
        let nome = $("#nome_alterar").val();
        // Obtém o valor do campo 'id_altera' do formulário
        let id = $("#id_alterar").val();

        // Envia uma requisição AJAX para alterar o Setor de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function () {
                Load();
            }, 
            type: 'post',
            url: BASE_URL_DATAVIEW('setorEquipamentoDataview'),
            data: {
                btn_alterar: 'ajx',
                id_alterar: id,
                nome_alterar: nome
            },
            // Ao receber uma resposta bem-sucedida
            success: function (ret) {
                // Exibe mensagens de retorno
                mensagensJS(ret);
                // Limpa os campos do formulário
                LimparCamposJS(formID);
                // Atualiza os detalhes do Setor de equipamento na tabela
                DetalharSetorEquipamento();
                // Fecha a janela modal após a conclusão bem-sucedida da alteração.
                fecharModal('modal-alterar');

            },
            // Ao completar a requisição, remove o indicador de carregamento
            complete: function () {
                RemoverLoad();
            }

        });

    }

}

function ExcluirAjax() {

    // Obtém o valor do campo 'id_alterar' do formulário
    let id = $("#id_excluir").val();

    // Envia uma requisição AJAX para excluir o tipo de equipamento
    $.ajax({

        // Antes de enviar a requisição, exibe o indicador de carregamento
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('setorEquipamentoDataview'),
        data: {
            btn_deletar: 'ajx',
            id_excluir: id
        },
        // Ao receber uma resposta bem-sucedida
        success: function (ret) {
            // Exibe mensagens de retorno
            mensagensJS(ret);
            // Atualiza os detalhes do tipo de equipamento na tabela
            DetalharSetorEquipamento();
            // Fecha a janela modal após a conclusão bem-sucedida da exclusão.
            fecharModal('modal-excluir');
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}
