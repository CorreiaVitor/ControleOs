// Função para cadastrar equipamento via AJAX.
function GravarEquipamentoAjax(formID) {

    // Verifica se os campos do formulário são válidos.
    if (validarCamposJS(formID)) {

        // Obtém os valores dos campos do formulário.
        let tipo = $("#tipoEqui").val();
        let modelo = $("#modeloEqui").val();
        let identificacao = $("#identificacao").val();
        let descricao = $("#descricao").val();
        let id = $("#id_equipamento").val();

        // Envia uma requisição AJAX para cadastrar ou alterar o equipamento.
        $.ajax({

            // Função executada antes do envio da requisição.
            beforeSend: function () {
                Load();
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('equipamentoDataview'),
            data: {
                btn_gravar: $("#btn_gravar").html() == 'Alterar' ? 'Alterar' : 'Cadastrar',
                tipoEqui: tipo,
                modeloEqui: modelo,
                identificacao: identificacao,
                descricao: descricao,
                id_equipamento: id
            },
            // Função executada em caso de sucesso na requisição.
            success: function (ret) {
                mensagensJS(ret);

                // Limpa os campos do formulário se for um cadastro.
                if ($("#id_equipamento").val() == '')
                    LimparCamposJS(formID);

            },
            // Função executada após a conclusão da requisição, independentemente de sucesso ou falha.
            complete: function () {
                RemoverLoad();
            }

        })

    }

}

// Função para carregar modelos de equipamento via AJAX.
function CarregarModeloEquipamentoAjax() {

    // Obtém o valor do modelo selecionado.
    let modelo = $("#id_modelo").val();

    // Envia uma requisição AJAX para carregar modelos de equipamento.
    $.ajax({
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('equipamentoDataview'),
        data: {
            carregar_modelo_equipamento: 'ajx',
            id_modelo: modelo
        },
        success: function (dados) {
            // Atualiza o HTML do elemento com os modelos de equipamento.
            $("#modeloEqui").html(dados);
        },
        complete: function () {
            RemoverLoad();
        }
    })
}

// Função para carregar tipos de equipamento via AJAX.
function CarregarTipoEquipamentoAjax() {

    // Obtém o valor do tipo selecionado.
    let tipo = $("#id_tipo").val();

    // Envia uma requisição AJAX para carregar tipos de equipamento.
    $.ajax({
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('equipamentoDataview'),
        data: {
            carregar_tipo_equipamento: 'ajx',
            id_tipo: tipo
        },
        success: function (dados) {
            // Atualiza o HTML do elemento com os tipos de equipamento.
            $("#tipoEqui").html(dados);
            console.log(id_tipo)
        },
        complete: function () {
            RemoverLoad();
        }
    })
}
function CarregarSetorEquipamentoAjax() {

    // Envia uma requisição AJAX para carregar tipos de equipamento.
    $.ajax({
        beforeSend: function () {
            Load();
        },
        type: 'post',
        url: BASE_URL_DATAVIEW('equipamentoDataview'),
        data: {
            carregar_setor_equipamento: 'ajx',
        },
        success: function (dados) {
            // Atualiza o HTML do elemento com os tipos de equipamento.
            $("#setor").html(dados);
        },
        complete: function () {
            RemoverLoad();
        }
    })
}

// Função para filtrar equipamentos via AJAX.
function FiltrarEquipamentoAjax() {

    // Obtém os valores dos campos de filtro.
    let nome = $("#nome").val();
    let tipo = $("#tipoEqui").val();
    let modelo = $("#modeloEqui").val();

    // Envia uma requisição AJAX para filtrar equipamentos.
    $.ajax({

        beforeSend: function () {
            Load();
        },
        type: "POST",
        url: BASE_URL_DATAVIEW('equipamentoDataview'),
        data: {
            filtrar_equipamentos: 'ajx',
            nome: nome,
            tipoEqui: tipo,
            modeloEqui: modelo
        },
        success: function (dados) {
            // Atualiza o HTML do elemento com os resultados do filtro.
            $("#tableResult").html(dados)

            console.log(tipo)
            console.log(modelo)
            // Exibe mensagem se nenhum resultado for encontrado e o nome não estiver vazio.
            MsgEqui($("#tableResult tbody tr").length, nome, tipo, modelo);
            // Define o foco no campo de nome.
            $("#nome").focus()
        },
        complete: function () {
            RemoverLoad();
        }

    })

}

function DescartarEquipamentoAjax(formID) {

    if (validarCamposJS(formID)) {

        $.ajax({
            beforeSend: function () {
                Load();
            },
            type: "post",
            url: BASE_URL_DATAVIEW('equipamentoDataview'),
            data: {
                btn_descarte: '',
                id_equipamento: $("#id_equipamento").val(),
                motivo_descarte: $("#motivo_descarte").val(),
                data_descarte: $("#data_descarte").val(),
            },
            success: function (ret) {

                mensagensJS(ret);
                LimparCamposJS(formID);
                fecharModal('modal-descarte');
                FiltrarEquipamentoAjax();

            },
            complete: function () {
                RemoverLoad();
            }
        })

    }

}

function ConsultarEquipamentoNaoAlocadoAjax() {

    $.ajax({
        beforeSend: function () {
            Load();
        },
        type: "POST",
        url: BASE_URL_DATAVIEW('equipamentoDataview'),
        data: {
            consultar_equipamento_nao_alocado: '',
        },
        success: function (dados) {
            $("#equipamento").html(dados);
        },
        complete: function () {
            RemoverLoad();
        },
    })

}

function AlocarEquipamentoAjax(formID) {

    if (validarCamposJS(formID)) {

        $.ajax({
            beforeSend: function () {
                Load();
            },
            type: "post",
            url: BASE_URL_DATAVIEW('equipamentoDataview'),
            data: {
                btn_alocar: '',
                equipamento: $("#equipamento").val(),
                setor: $("#setor").val(),
            },
            success: function (ret) {

                mensagensJS(ret);
                LimparCamposJS(formID);
                ConsultarEquipamentoNaoAlocadoAjax();

            },
            complete: function () {
                RemoverLoad();
            }
        })

    }

}

function EquipamentoAlocadoSetorAjax() {

    let setor = $("#setor").val();
    console.log(setor);
    // Envia uma requisição AJAX para carregar modelos de equipamento.
    if (setor != '') {
        $.ajax({
            beforeSend: function () {
                Load();
            },
            type: 'post',
            url: BASE_URL_DATAVIEW('equipamentoDataview'),
            data: {
                equipamento_alocado_setor: 'ajx',
                setor: setor
            },
            success: function (dados) {
                // Atualiza o HTML do elemento com os modelos de equipamento.
                $("#tableResults").html(dados);
                $("#divResultado").show();


            },
            complete: function () {
                RemoverLoad();
            }
        })
    } else {
        $("#tableResults").html('');
        $("#divResultado").hide();
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
        url: BASE_URL_DATAVIEW('EquipamentoDataview'),
        data: {
            btn_deletar: 'ajx',
            id_excluir: id
        },
        // Ao receber uma resposta bem-sucedida
        success: function (ret) {
            // Exibe mensagens de retorno
            mensagensJS(ret);
            // Atualiza os detalhes do tipo de equipamento na tabela
            EquipamentoAlocadoSetorAjax();
            
            // Fecha a janela modal após a conclusão bem-sucedida da exclusão.
            fecharModal('modal-excluir');

            console.log($("#setor").val())
        },
        // Ao completar a requisição, remove o indicador de carregamento
        complete: function () {
            RemoverLoad();
        }

    });

}