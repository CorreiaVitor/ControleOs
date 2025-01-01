// Função em JavaScript para cadastrar um novo modelo de equipamento via AJAX
function CadastrarModeloEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if (validarCamposJS(formID)) {

        // Obtém o valor do campo 'nome_modelo' do formulário
        let nome = $("#nome_modelo").val();

        // Envia uma requisição AJAX para cadastrar o Modelo de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function () {
                Load();
            },
            type: 'post',
            url: BASE_URL_DATAVIEW('modeloEquipamentoDataview'),
            data: {
                nome_modelo: nome,
                btn_cadastrar: 'ajx'
            },
            // Ao receber uma resposta bem-sucedida
            success: function (ret) {
                // Exibe mensagens de retorno
                mensagensJS(ret);
                // Limpa os campos do formulário
                LimparCamposJS(formID);
                // Atualiza os detalhes do modelo de equipamento na tabela
                DetalharModeloEquipamento();
            },
            // Ao completar a requisição, remove o indicador de carregamento
            complete: function () {
                RemoverLoad();
            }

        });

    }

}

// Função em JavaScript para obter e exibir detalhes de modelos de equipamento via AJAX
function DetalharModeloEquipamento() {

    // Envia uma requisição AJAX para obter a consulta do banco de dados dos modelos de equipamento
    $.ajax({

        // Antes de enviar a requisição, exibe o indicador de carregamento
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('modeloEquipamentoDataview'),
        data: {
            detelhar_modelo_equipamento: 'ajx',
        },
        // Ao receber uma resposta bem-sucedida, atualiza a tabela com os dados obtidos
        success: function (dados) {
            $("#tableResult").html(dados);
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}

function AlterarModeloEquipamentoAjax(formID) {

    // Verifica se os campos do formulário estão preenchidos corretamente
    if (validarCamposJS(formID)) {

        // Obtém o valor do campo 'nome_alterar' do formulário
        let nome = $("#nome_alterar").val();
        // Obtém o valor do campo 'id_altera' do formulário
        let id = $("#id_alterar").val();

        // Envia uma requisição AJAX para alterar o Modelo de equipamento
        $.ajax({

            // Antes de enviar a requisição, exibe o indicador de carregamento
            beforeSend: function () {
                Load();
            }, 
            type: 'post',
            url: BASE_URL_DATAVIEW('modeloEquipamentoDataview'),
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
                // Atualiza os detalhes do modelo de equipamento na tabela
                DetalharModeloEquipamento();
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
        url: BASE_URL_DATAVIEW('modeloEquipamentoDataview'),
        data: {
            btn_deletar: 'ajx',
            id_excluir: id
        },
        // Ao receber uma resposta bem-sucedida
        success: function (ret) {
            // Exibe mensagens de retorno
            mensagensJS(ret);
            // Atualiza os detalhes do tipo de equipamento na tabela
            DetalharModeloEquipamento();
            // Fecha a janela modal após a conclusão bem-sucedida da exclusão.
            fecharModal('modal-excluir');
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}
