function VerificarEmailCadastrado(email) {
    // Valida o formato do email e verifica se já está cadastrado
    if (ValidarEmail(email)) {
        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                verificar_email_cadastrado: '', // Indica que estamos verificando o email
                email: email
            },
            success: function (ret) {
                // Se o email já estiver cadastrado, limpa o campo e exibe mensagem
                if (ret) {
                    mensagensJS(-7);
                    $("#email").val('')
                }
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        })
    }
}

function VerificarCpfCadastrado(cpf) {
    // Valida o CPF e verifica se já está cadastrado
    if (ValidarCpf(cpf)) {
        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                verificar_cpf_cadastrado: '', // Indica que estamos verificando o CPF
                cpf: cpf
            },
            success: function (ret) {
                // Se o CPF já estiver cadastrado, limpa o campo e exibe mensagem
                if (ret) {
                    mensagensJS(-11);
                    $("#email").val('')
                }
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        })
    }
}

function CadastrarUsuarioAjax(formID) {
    // Valida os campos e realiza o cadastro de um novo usuário
    if (validarCamposJS(formID)) {
        let tipo = $("#tipo_usuario").val();

        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                btn_cadastrar: 'ajx', // Ação para cadastro via AJAX
                tipo_usuario: tipo,
                nome: $("#nome").val(),
                email: $("#email").val(),
                cpf: $("#cpf").val(),
                telefone: $("#telefone").val(),
                rua: $("#rua").val(),
                bairro: $("#bairro").val(),
                cep: $("#cep").val(),
                cidade: $("#cidade").val(),
                estado: $("#estado").val(),
                empresa: tipo == 3 ? $("#empresa").val() : '',
                setor: tipo == 2 ? $("#setor").val() : ''
            },
            success: function (ret) {
                mensagensJS(ret); // Exibe mensagens com o resultado
                if (ret == 1) {
                    CarregarCamposUsuarioJS(0) // Limpa os campos após o cadastro
                }
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        })
    }
}

function AlterarUsuarioAjax(formID) {
    // Valida os campos e realiza a alteração de dados do usuário
    if (validarCamposJS(formID)) {
        let tipo = $("#tipo_usuario").val();
        let id_usuario = $("#id_usuario").val();
        let id_endereco = $("#id_endereco").val();
        let nome_usuario = $("#nome").val();

        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                btn_alterar: 'ajx', // Ação para alteração via AJAX
                tipo_usuario: tipo,
                id_usuario: id_usuario,
                id_endereco: id_endereco,
                empresa: tipo == 3 ? $("#empresa").val() : '',
                setor: tipo == 2 ? $("#setor").val() : '',
                nome: nome_usuario,
                email: $("#email").val(),
                cpf: $("#cpf").val(),
                telefone: $("#telefone").val(),
                rua: $("#rua").val(),
                bairro: $("#bairro").val(),
                cep: $("#cep").val(),
                cidade: $("#cidade").val(),
                estado: $("#estado").val()
            },
            success: function (ret) {
                mensagensJS(ret); // Exibe mensagens com o resultado
                RedirecionarPag("consultar_usuario.php?usuario=" + nome_usuario) // Redireciona após alteração
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        })
    }
}

function FiltrarUsuarioAjax() {
    // Filtra os usuários com base no nome informado
    let nome = $("#nome_usuario").val();

    if (nome != '') {
        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                consultar_usuario: '', // Ação para consultar usuários
                nome_usuario: nome
            },
            success: function (dados) {
                $("#tableResult").html(dados); // Exibe o resultado na tabela
                $("#divResult").show(); // Mostra os resultados
                if ($("#tableResult tbody tr").length == 0 && nome != '') {
                    mensagensJS(-9); // Mensagem caso não encontre resultados
                }
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        });
    } else {
        $("#divResult").hide() // Oculta os resultados se o campo estiver vazio
    }
}

function InativarUsuarioAjax(id, status) {
    // Inativa ou ativa o status de um usuário
    $.ajax({
        beforeSend: function () {
            Load(); // Exibe o carregamento
        },
        type: "POST",
        url: BASE_URL_DATAVIEW('usuarioDataview'),
        data: {
            inativar_usuario: '', // Ação para inativar/ativar o usuário
            id_usuario: id,
            status_usuario: status
        },
        success: function (ret) {
            mensagensJS(ret); // Exibe mensagens com o resultado
            if (ret == 1) {
                FiltrarUsuarioAjax(); // Atualiza a lista de usuários
            }
        },
        complete: function () {
            RemoverLoad(); // Remove o carregamento
        }
    })
}

function LoginAjax(formID) {
    // Valida os campos e realiza o login do usuário
    if (validarCamposJS(formID)) {
        let login = $("#login_usuario").val();
        let senha = $("#senha_usuario").val();

        $.ajax({
            beforeSend: function () {
                Load(); // Exibe o carregamento
            },
            type: "POST",
            url: BASE_URL_DATAVIEW('usuarioDataview'),
            data: {
                btn_logar: '', // Ação para login via AJAX
                login_usuario: login,
                senha_usuario: senha
            },
            success: function (ret) {
                mensagensJS(ret); // Exibe mensagens com o resultado
            },
            complete: function () {
                RemoverLoad(); // Remove o carregamento
            }
        })
    }
}
