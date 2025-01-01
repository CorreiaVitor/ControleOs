// Função em JavaScript para cadastrar um novo tipo de equipamento via AJAX
function CadastrarTipoEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if (validarCamposJS(formID)) {

        // Obtém o valor do campo 'nome_tipo' do formulário
        let nome = $("#nome_tipo").val();

        // Envia uma requisição AJAX para cadastrar o tipo de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function () {
                Load();
            },
            type: 'post',
            url: BASE_URL_DATAVIEW('tipoEquipamentoDataview'),
            data: {
                nome_tipo: nome,
                btn_cadastrar: 'ajx'
            },
            // Ao receber uma resposta bem-sucedida
            success: function (ret) {
                // Exibe mensagens de retorno
                mensagensJS(ret);
                // Limpa os campos do formulário
                LimparCamposJS(formID);
                // Atualiza os detalhes do tipo de equipamento na tabela
                DetalharTipoEquipamento();
            },
            // Ao completar a requisição, remove o indicador de carregamento
            complete: function () {
                RemoverLoad();
            }

        });

    }

}

// Função em JavaScript para obter e exibir detalhes de tipos de equipamento via AJAX
function DetalharTipoEquipamento() {

    // Envia uma requisição AJAX para obter detalhes de tipos de equipamento
    $.ajax({

        // Antes de enviar a requisição, exibe o indicador de carregamento
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('tipoEquipamentoDataview'),
        data: {
            detelhar_tipo_equipamento: 'ajx',
        },
        // Ao receber uma resposta bem-sucedida, atualiza a tabela com os dados obtidos
        success: function (dados) {
            $("#tableResult").html(dados);
            $("#modeloEqui").val(dados),
            $("#tipoEqui").val(dados)
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}

// Função em JavaScript para alterar o tipo de equipamento por meio de uma requisição AJAX.
function AlterarTipoEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if (validarCamposJS(formID)) {

        // Obtém o valor do campo 'nome_tipo' do formulário
        let nome = $("#nome_alterar").val();
        // Obtém o valor do campo 'id_alterar' do formulário
        let id = $("#id_alterar").val();

        // Envia uma requisição AJAX para alterar o tipo de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function () {
                Load();
            },
            type: 'post',
            url: BASE_URL_DATAVIEW('tipoEquipamentoDataview'),
            data: {
                nome_alterar: nome,
                id_alterar: id,
                btn_alterar: 'ajx'
            },
            // Ao receber uma resposta bem-sucedida
            success: function (ret) {
                // Exibe mensagens de retorno
                mensagensJS(ret);
                // Limpa os campos do formulário
                LimparCamposJS(formID);
                // Atualiza os detalhes do tipo de equipamento na tabela
                DetalharTipoEquipamento();
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
        url: BASE_URL_DATAVIEW('tipoEquipamentoDataview'),
        data: {
            btn_deletar: 'ajx',
            id_excluir: id
        },
        // Ao receber uma resposta bem-sucedida
        success: function (ret) {
            // Exibe mensagens de retorno
            mensagensJS(ret);
            // Atualiza os detalhes do tipo de equipamento na tabela
            DetalharTipoEquipamento();
            // Fecha a janela modal após a conclusão bem-sucedida da exclusão.
            fecharModal('modal-excluir');
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}


