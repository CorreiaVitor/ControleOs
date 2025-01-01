// Função para gravar os dados do usuário na API
async function GravarMeusDadosApi(formID) {
    // Verifica se os campos do formulário estão válidos
    if (ValidarCamposJS(formID)) {
        const dados = {
            // Coleta os dados do formulário para envio à API
            id_usuario: CodigoLogado(),
            endpoint: API_GRAVAR_MEUS_DADOS,
            empresa: PegarCampoValor('empresa'),
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
            Load();  // Exibe o carregamento enquanto a API processa

            // Envia os dados para a API
            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dados)
            });

            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);  // Erro se a resposta não for válida
            }

            const objDados = await response.json();  // Processa a resposta da API

            if(objDados.result == NAO_AUTORIZADO){
                Sair();  // Desloga se não autorizado
                return;
            }

            MensagemApiJS(MSG_SUCCESSO ,objDados.result);  // Exibe mensagem de sucesso
        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);  // Exibe mensagem de erro
        } finally {
            RemoverLoad();  // Remove o carregamento
        }
    }
}

// Função para detalhar os dados do usuário na API
async function DetalharMeusDadosApi() {
    try {
        const dados = {
            id_user: CodigoLogado(),
            endpoint: API_DETALHAR_USUARIO
        };

        Load();  // Exibe o carregamento enquanto a API processa

        // Solicita os dados do usuário à API
        const response = await fetch(BASE_URL_API(), {
            method: "POST",
            headers: HEADER_COM_AUTENTICACAO(),
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error(MSG_ERRO_CALL_API);  // Erro se a resposta não for válida
        }

        const objDados = await response.json();
        const dadosUser = objDados.result;

        if(objDados.result == NAO_AUTORIZADO){
            Sair();  // Desloga se não autorizado
            return;
        }

        // Preenche os campos do formulário com os dados recebidos da API
        SetarCampoValor("nome", dadosUser.nome_usuario);
        SetarCampoValor("telefone", dadosUser.tel_usuario);
        SetarCampoValor("cpf", dadosUser.cpf_usuario);
        SetarCampoValor("email", dadosUser.email_usuario);
        SetarCampoValor("empresa", dadosUser.nome_empresa);
        SetarCampoValor("cep", dadosUser.cep);
        SetarCampoValor("rua", dadosUser.rua);
        SetarCampoValor("bairro", dadosUser.bairro);
        SetarCampoValor("estado", dadosUser.sigla_estado);
        SetarCampoValor("cidade", dadosUser.nome_cidade);
        SetarCampoValor("id_endereco", dadosUser.id_endereco);
        SetarCampoValor("tipo_usuario", dadosUser.tipo_usuario);

        console.log(dadosUser);  // Exibe dados para depuração
    } catch (error) {
        MensagemApiJS(error.message, COR_MSG_ERROR);  // Exibe mensagem de erro
    } finally {
        RemoverLoad();  // Remove o carregamento
    }
}

// Função para verificar a senha atual do usuário
async function VerificarSenhaAtual(formID, formID2) {
    if (ValidarCamposJS(formID)) {
        try {
            const dados = {
                endpoint: API_VERIFICAR_SENHA_ATUAL,
                id_user: CodigoLogado(),
                senha_digitada: PegarCampoValor("senha_atual")
            };

            Load();  // Exibe o carregamento enquanto a API processa

            // Solicita a verificação da senha atual à API
            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dados)
            });

            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);  // Erro se a resposta não for válida
            }

            const objDados = await response.json();  // Processa a resposta da API

            if(objDados.result == NAO_AUTORIZADO){
                Sair();  // Desloga se não autorizado
                return;
            }

            // Se a senha for correta, exibe o segundo formulário
            if (objDados.result == 1) {
                document.getElementById(formID).classList.add("d-none");
                document.getElementById(formID2).classList.remove("d-none");
            } else if (objDados.result == -1) {
                MensagemApiJS(MSG_SENHA_INCORRETA, COR_MSG_ERROR);  // Senha incorreta
            }

        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);  // Exibe mensagem de erro
        } finally {
            RemoverLoad();  // Remove o carregamento
        }
    }
}

// Função para mudar a senha do usuário
async function MudarSenhaUsuario(formID, formID2) {
    if (await ValidarCamposJSAsync(formID)) {
        const nova_senha = PegarCampoValor("nova_senha");
        const repetir_senha = PegarCampoValor("r_senha");

        // Verifica se a nova senha atende aos critérios
        if (nova_senha.length < TAMANHO_SENHA_PERMITIDA) {
            MensagemApiJS(MSG_COMPRIMENTO_SENHA, COR_MSG_ATENCAO);  // Aviso de comprimento de senha
        } else if (nova_senha !== repetir_senha) {
            MensagemApiJS(MSG_REPETIR_SENHA, COR_MSG_ATENCAO);  // Aviso de senhas não coincidentes
        } else {
            const dadosEnviar = {
                endpoint: API_ALTERAR_SENHA_ATUAL,
                nova_senha: PegarCampoValor("nova_senha"),
                id_usuario: CodigoLogado()
            };

            try {
                Load();  // Exibe o carregamento enquanto a API processa

                // Solicita a mudança de senha à API
                const response = await fetch(BASE_URL_API(), {
                    method: "POST",
                    headers: HEADER_COM_AUTENTICACAO(),
                    body: JSON.stringify(dadosEnviar)
                });

                if (!response.ok) {
                    throw new Error(MSG_ERRO_CALL_API);  // Erro se a resposta não for válida
                }

                const objDados = await response.json();  // Processa a resposta da API

                if(objDados.result == NAO_AUTORIZADO){
                    Sair();  // Desloga se não autorizado
                    return;
                }

                // Exibe mensagem de sucesso ou erro
                if (objDados.result === 1) {
                    MensagemApiJS(MSG_SUCCESSO, COR_MSG_SUCESSO);
                    await LimparNotificacoesAsync(formID)
                    await LimparNotificacoesAsync(formID2)
                    document.getElementById(formID2).classList.remove("d-none");
                    document.getElementById(formID).classList.add("d-none");
                } else if (objDados.result === -1) {
                    MensagemApiJS(MSG_ERRO, COR_MSG_ERROR);
                }

            } catch (error) {
                MensagemApiJS(error.message, COR_MSG_ERROR);  // Exibe mensagem de erro
            } finally {
                RemoverLoad();  // Remove o carregamento
            }
        }
    }
}

// Função para acessar a conta do usuário
async function Acessar(formID) {
    if (await ValidarCamposJSAsync(formID)) {
        const login = PegarCampoValor("login_usuario");
        const senha = PegarCampoValor("senha_usuario");

        const dadosEnviar = {
            endpoint: API_ACESSAR,
            login: login,
            senha: senha
        };

        try {
            Load();  // Exibe o carregamento enquanto a API processa

            // Solicita o acesso à API
            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_SEM_AUTENTICACAO(),
                body: JSON.stringify(dadosEnviar)
            });

            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);  // Erro se a resposta não for válida
            }

            const objDados = await response.json();  // Processa a resposta da API

            if (objDados.result === -9) {
                MensagemApiJS(MSG_USUARIO_NAO_ENCONTRADO, COR_MSG_INFO);  // Usuário não encontrado
                return;
            }

            // Adiciona o token e redireciona
            AddTnk(objDados.result);
            const objDadosToken = GetTnkValue();
            setNomeLogado(objDadosToken.nome);
            RedirecionarPag('tecnico/meus_dados');

        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);  // Exibe mensagem de erro
        } finally {
            RemoverLoad();  // Remove o carregamento
        }
    }
}
