// Função para gravar dados do usuário
async function GravarMeusDadosApi(formID) {
    if (ValidarCamposJS(formID)) {
        const dados = {
            id_usuario: CodigoLogado(),
            endpoint: API_GRAVAR_MEUS_DADOS,
            setor: CodigoSetorLogado(),
            nome: PegarCampoValor('nome'),
            email: PegarCampoValor('email'),
            cpf: PegarCampoValor('cpf'),
            telefone: PegarCampoValor('telefone'),
            id_endereco: PegarCampoValor('id_endereco'),
            rua: PegarCampoValor('rua'),
            bairro: PegarCampoValor('bairro'),
            cep: PegarCampoValor('cep'),
            cidade: PegarCampoValor('cidade'),
            estado: PegarCampoValor('estado'),
            tipo_usuario: PegarCampoValor('tipo_usuario')
        };

        try {
            Load();

            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dados)
            });

            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);
            }

            const objDados = await response.json();

            if (objDados.result === NAO_AUTORIZADO) {
                Sair();
                return;
            }

            MensagemApiJS(objDados.result === 1 ? MSG_SUCCESSO : MSG_ERRO, objDados.result === 1 ? COR_MSG_SUCESSO : COR_MSG_ERROR);
        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            RemoverLoad();
        }
    }
}

// Função para detalhar dados do usuário
async function DetalharMeusDadosApi() {
    try {
        const dados = {
            id_user: CodigoLogado(),
            endpoint: API_DETALHAR_USUARIO
        };

        Load();

        const response = await fetch(BASE_URL_API(), {
            method: "POST",
            headers: HEADER_COM_AUTENTICACAO(),
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error(MSG_ERRO_CALL_API);
        }

        const objDados = await response.json();

        if (objDados.result === NAO_AUTORIZADO) {
            Sair();
            return;
        }

        const dadosUser = objDados.result;
        SetarCampoValor("nome", dadosUser.nome_usuario);
        SetarCampoValor("telefone", dadosUser.tel_usuario);
        SetarCampoValor("cpf", dadosUser.cpf_usuario);
        SetarCampoValor("email", dadosUser.email_usuario);
        SetarCampoValor("setor", dadosUser.nome_setor);
        SetarCampoValor("cep", dadosUser.cep);
        SetarCampoValor("rua", dadosUser.rua);
        SetarCampoValor("bairro", dadosUser.bairro);
        SetarCampoValor("estado", dadosUser.sigla_estado);
        SetarCampoValor("cidade", dadosUser.nome_cidade);
        SetarCampoValor("id_endereco", dadosUser.id_endereco);
        SetarCampoValor("tipo_usuario", dadosUser.tipo_usuario);
    } catch (error) {
        MensagemApiJS(error.message, COR_MSG_ERROR);
    } finally {
        RemoverLoad();
    }
}

// Função para verificar senha atual
async function VerificarSenhaAtual(formID, formID2) {
    if (ValidarCamposJS(formID)) {
        try {
            const dados = {
                endpoint: API_VERIFICAR_SENHA_ATUAL,
                id_user: CodigoLogado(),
                senha_digitada: PegarCampoValor("senha_atual")
            };

            Load();

            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dados)
            });

            if (!response.ok) throw new Error(MSG_ERRO_CALL_API);

            const objDados = await response.json();

            if (objDados.result === NAO_AUTORIZADO) {
                Sair();
                return;
            }

            if (objDados.result === 1) {
                document.getElementById(formID).classList.add("d-none");
                document.getElementById(formID2).classList.remove("d-none");
            } else if (objDados.result === -1) {
                MensagemApiJS(MSG_SENHA_INCORRETA, COR_MSG_ERROR);
            }
        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            RemoverLoad();
        }
    }
}

// Função para mudar senha do usuário
async function MudarSenhaUsuario(formID, formID2) {
    if (await ValidarCamposJSAsync(formID)) {
        const nova_senha = PegarCampoValor("nova_senha");
        const repetir_senha = PegarCampoValor("r_senha");

        if (nova_senha.length < TAMANHO_SENHA_PERMITIDA) {
            MensagemApiJS(MSG_COMPRIMENTO_SENHA, COR_MSG_ATENCAO);
        } else if (nova_senha !== repetir_senha) {
            MensagemApiJS(MSG_REPETIR_SENHA, COR_MSG_ATENCAO);
        } else {
            const dadosEnviar = {
                endpoint: API_ALTERAR_SENHA_ATUAL,
                nova_senha,
                id_usuario: CodigoLogado()
            };

            try {
                Load();

                const response = await fetch(BASE_URL_API(), {
                    method: "POST",
                    headers: HEADER_COM_AUTENTICACAO(),
                    body: JSON.stringify(dadosEnviar)
                });

                if (!response.ok) {
                    throw new Error(MSG_ERRO_CALL_API);
                }

                const objDados = await response.json();

                if (objDados.result === NAO_AUTORIZADO) {
                    Sair();
                    return;
                }

                if (objDados.result === 1) {
                    MensagemApiJS(MSG_SUCCESSO, COR_MSG_SUCESSO);
                    await LimparNotificacoesAsync(formID);
                    await LimparNotificacoesAsync(formID2);
                    document.getElementById(formID2).classList.remove("d-none");
                    document.getElementById(formID).classList.add("d-none");
                } else if (objDados.result === -1) {
                    MensagemApiJS(MSG_ERRO, COR_MSG_ERROR);
                }
            } catch (error) {
                MensagemApiJS(error.message, COR_MSG_ERROR);
            } finally {
                RemoverLoad();
            }
        }
    }
}

// Função para acessar o sistema
async function Acessar(formID) {
    if (await ValidarCamposJSAsync(formID)) {
        const login = PegarCampoValor("login_usuario");
        const senha = PegarCampoValor("senha_usuario");

        const dadosEnviar = {
            endpoint: API_ACESSAR,
            login,
            senha
        };

        try {
            Load();

            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_SEM_AUTENTICACAO(),
                body: JSON.stringify(dadosEnviar)
            });

            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);
            }

            const objDados = await response.json();

            if (objDados.result === -9) {
                MensagemApiJS(MSG_USUARIO_NAO_ENCONTRADO, COR_MSG_INFO);
                return;
            }

            AddTnk(objDados.result);
            const objDadosToken = GetTnkValue();
            setNomeLogado(objDadosToken.nome);
            RedirecionarPag('funcionario/meus_dados');
        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            RemoverLoad();
        }
    }
}
