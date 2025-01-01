//#region Funções genericas do projeto
function BASE_URL_DATAVIEW(url) {
    return '../../Resource/dataview/' + url + '.php';
}

function BASE_PATH() {
    return "http://localhost/ControleOs/ControleOs/src/View/admin/";
}
//Função JS para verificar campos vazios em um formulário usando seu ID.
function validarCamposJS(formID) {
    let ret = true;

    //laço de repetição foreach em jQuery que irá percorrer os id com campos
    $(`#${formID}input #${formID}select #${formID} textarea`).each(function () {

        // Verifica se o campo possui a classe "obg" (obrigatório)
        if ($(this).hasClass("obg")) {
            // Verifica se o valor do campo está vazio
            if ($(this).val() == "") {
                ret = false;
                $(this).addClass("is-invalid");
            } else {
                // Remove as classes de validação se o campo estiver preenchido
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        }
    });

    if (!ret)
        mensagensJS(0);

    return ret;
}
// Função em JavaScript para exibir um indicador de carregamento
function Load() {
    $(".loader").addClass("is-active");
}
// Função em JavaScript para remover o indicador de carregamento
function RemoverLoad() {
    $(".loader").removeClass("is-active");
}
// Função em JavaScript para limpar os campos de um formulário com base no seu ID
function LimparCamposJS(formID) {
    $("#" + formID + " input, #" + formID + " select, #" + formID + " textarea").each(function () {
        // Limpa o valor do campo e remove classes de validação
        $(this).val('');
        $(this).removeClass('is-invalid').removeClass('is-valid');
    });
}

function fecharModal(nome_modal) {
    $("#" + nome_modal).modal("hide")
}

function MsgEqui(tabela, nome, tipo, modelo) {

    if (tabela == 0 && (nome != '' || tipo != null || modelo != null)) {
        mensagensJS(-2);
    }

}

function ValidarCpf(cpf) {

    let result = true;
    if (cpf != "") {
        cpf = cpf.replace(/\D/g, '');
        if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) {
            mensagensJS(-5);
            $("#cpf").val('');
            return false;
        }

        [9, 10].forEach(function (j) {
            var soma = 0,
                r;
            cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
                soma += parseInt(e) * ((j + 2) - (i + 1));
            });
            r = soma % 11;
            r = (r < 2) ? 0 : 11 - r;
            if (r != cpf.substring(j, j + 1)) {
                result = false;
            }
        });

        if (!result) {
            mensagensJS(-5);
            $("#cpf").val('');
        }
    }
    return result;
}

function ValidarEmail(email) {
    let re = /\S+@\S+\.\S+/;
    let retorno = true;

    if (!re.test(email)) {
        $("#email").val('');
        mensagensJS(-6);
        retorno = false;
    }

    return retorno;
}

function RedirecionarPag(url) {
    setTimeout(() => { window.location = BASE_PATH() + url; }, 1000);
}

//#endregion

//#region Funçoes da TELA USUÁRIO

function CarregarCamposUsuarioJS(tipo) {

    $("#divDadosUsuario").show()
    $("#divDadosEndereco").show()
    $("#btn_cadastrar").show()

    //remove o obg do tecnico
    $("#empresa").removeClass('obg')
    //remove o obg do funcionario
    $("#setor").removeClass('obg')
    LimparCamposJS("formUser");
    $("#tipo_usuario").val(tipo);


    switch (tipo) {
        case '1':
            $("#divUsuarioFuncionario").hide()
            $("#divUsuarioTecnico").hide()
            break;
        case '2':
            $("#divUsuarioFuncionario").show()
            $("#btn_cadastrar").show()

            $("#divUsuarioTecnico").hide()

            //setar o obg
            $("#setor").addClass('obg')
            break;
        case '3':
            $("#divUsuarioTecnico").show()
            $("#btn_cadastrar").show()

            $("#divUsuarioFuncionario").hide()

            //setar o obg
            $("#empresa").addClass('obg')
            break;

        default:
            $("#divDadosUsuario").hide()
            $("#divDadosEndereco").hide()
            $("#btn_cadastrar").hide()

            $("#divUsuarioFuncionario").hide()
            $("#divUsuarioTecnico").hide()
            break;
    }

}

//#endregion



