// Função para detalhar informações de um chamado específico
async function DetalharChamado(id_chamado) {
    if (id_chamado != "") {
        // Dados a serem enviados para a API
        const dadosEnviar = {
            endpoint: API_DETALHAR_CHAMADO,
            id: id_chamado
        }

        try {
            // Exibe a tela de carregamento
            Load();

            // Chamada API para buscar detalhes do chamado
            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dadosEnviar)
            });

            // Se houver erro na resposta da API, lança exceção
            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);
            }

            // Converte a resposta em JSON
            const objDados = await response.json();

            // Verifica se o usuário está autorizado
            if (objDados.result == NAO_AUTORIZADO) {
                Sair(); // Sair se não autorizado
                return;
            }

            const chamado = objDados.result;

            // Preenche os campos com os dados do chamado
            SetarCampoValor("equipamento", chamado.nome_tipo + ' / ' + chamado.nome_modelo + ' / ' + chamado.identificacao);
            SetarCampoValor("data_abertura", chamado.data_abertura);
            SetarCampoValor("problema", chamado.problema);
            SetarCampoValor("id_chamado", chamado.id_chamado);
            SetarCampoValor("id_alocar", chamado.id_alocar);
            SetarCampoValor("tec_ini", chamado.tecnico_atendimento);
            SetarCampoValor("data_atendimento", chamado.data_abertura);
            SetarCampoValor("laudo", chamado.laudo);
            SetarCampoValor("data_encerramento", chamado.data_encerramento);
            SetarCampoValor("tec_fina", chamado.tecnico_finalizado);

            // Determina a situação atual do chamado
            const situacao_atual = VerSituacao(chamado.data_atendimento, chamado.data_encerramento);

            // Controla a visibilidade e habilitação dos campos com base na situação
            switch (situacao_atual) {
                case AGUARDANDO_ATENDIMENTO:
                    MostrarElemento("tecAtendimento", false)
                    MostrarElemento("tecEncerramento", false)
                    MostrarElemento("btn_acao", true)
                    MostrarElemento("btn_finalizar", false)
                    break;
                case EM_ATENDIMENTO:
                    MostrarElemento("tecAtendimento", true)
                    MostrarElemento("tecEncerramento", false)
                    MostrarElemento("btn_acao", false)
                    MostrarElemento("btn_finalizar", true)
                    HabilitarCampo("laudo", true)
                    break;
                case ATENDIMENTO_ENCERRADO:
                    MostrarElemento("tecAtendimento", true)
                    MostrarElemento("tecEncerramento", true)
                    MostrarElemento("btn_acao", false)
                    MostrarElemento("btn_finalizar", false)
                    HabilitarCampo("laudo", false)
                    break;
                default:
                    break;
            }

        } catch (error) {
            // Mensagem de erro caso haja problema na API
            MensagemApiJS(error.message, COR_MSG_ERROR)
        } finally {
            // Remover o carregamento da tela
            RemoverLoad();
        }

    }
}

// Função para filtrar e listar os chamados com base na situação
async function FiltrarChamado() {
    // Esconde o resultado até que a pesquisa seja concluída
    MostrarElemento("resultado", false);

    const dadosEnviar = {
        endpoint: API_FILTRAR_CHAMADO,
        situacao: PegarCampoValor("situacao"),
    }

    try {
        // Exibe a tela de carregamento
        Load();

        // Chamada API para buscar os chamados filtrados
        const response = await fetch(BASE_URL_API(), {
            method: "POST",
            headers: HEADER_COM_AUTENTICACAO(),
            body: JSON.stringify(dadosEnviar)
        });

        // Se houver erro na resposta da API, lança exceção
        if (!response.ok) {
            throw new Error(MSG_ERRO_CALL_API);
        }

        // Converte a resposta em JSON
        const objDados = await response.json();

        // Verifica se o usuário está autorizado
        if (objDados.result == NAO_AUTORIZADO) {
            Sair(); // Sair se não autorizado
            return;
        }

        const chamados = objDados.result;

        // Se não encontrar chamados, exibe uma mensagem informando
        if (chamados.length === 0) {
            MensagemApiJS(MSG_DADOS_NAO_ENCONTRADO, COR_MSG_INFO);
            return;
        }

        // Preenche a tabela com os chamados encontrados
        const tab_result = document.getElementById("table_result");

        let tab_content = `<thead>
                                <tr>
                                    <th></th>
                                    <th>Data Aberta</th>
                                    <th>Situação</th>
                                    <th>Funcionário</th>
                                    <th>Equipamento</th>
                                    <th>Problema</th>
                                </tr>
                            </thead>
                        </tbody>`

        let data_tr = '';
        let situacao = '';

        chamados.forEach((item) => {

            // Determina a situação de cada chamado
            situacao = VerSituacao(item.data_atendimento, item.data_encerramento);

            // Preenche as linhas da tabela com as informações do chamado
            data_tr += `<tr>
                            <td><a href="#" data-toggle="modal" onclick="DetalharChamado(${item.id_chamado})" data-target="#modal-chamados" class="btn btn-warning btn-xs">Ver detalhes</a></td>
                            <td>${item.data_abertura}</td>
                            <td>${situacao}</td>
                            <td>${item.funcionario}</td>
                            <td>${item.nome_tipo + " / " + item.nome_modelo + " / " + item.identificacao}</td>
                            <td>${item.problema}</td>
                        </tr>`
        });

        tab_content += data_tr;
        tab_content += " </tbody>";
        tab_result.innerHTML = tab_content;

        // Exibe o resultado da pesquisa
        MostrarElemento("resultado", true);

    } catch (error) {
        // Mensagem de erro caso haja problema na API
        MensagemApiJS(error.message, COR_MSG_ERROR);
    } finally {
        // Remover o carregamento da tela
        RemoverLoad();
    }
}

// Função para atender um chamado
async function AtenderChamado() {
    try {
        // Exibe a tela de carregamento
        Load()

        const id_chamado = PegarCampoValor("id_chamado");

        const dadosEnviar = {
            id_tec: CodigoLogado(),
            id_chamado: id_chamado,
            endpoint: API_ATENDER_CHAMADO
        };

        // Chamada API para atender o chamado
        const response = await fetch(BASE_URL_API(), {
            method: "POST",
            headers: HEADER_COM_AUTENTICACAO(),
            body: JSON.stringify(dadosEnviar)
        });

        // Se houver erro na resposta da API, lança exceção
        if (!response.ok) {
            throw new Error(MSG_ERRO_CALL_API);
        }

        // Converte a resposta em JSON
        const objDados = await response.json();

        // Verifica se o usuário está autorizado
        if (objDados.result == NAO_AUTORIZADO) {
            Sair(); // Sair se não autorizado
            return;
        }

        // Exibe mensagem de sucesso ou erro
        if (objDados.result === 1) {
            MensagemApiJS(MSG_SUCCESSO, COR_MSG_SUCESSO);
            FecharModal("modal-chamados");
            FiltrarChamado(); // Recarrega a lista de chamados
        } else {
            MensagemApiJS(MSG_ERRO, COR_MSG_ERROR);
        }

    } catch (error) {
        // Mensagem de erro caso haja problema na API
        MensagemApiJS(error.message, COR_MSG_ERROR);
    } finally {
        // Remover o carregamento da tela
        RemoverLoad();
    }
}

// Função para finalizar um chamado
async function FinalizarChamado(formID) {

    if (await ValidarCamposJSAsync(formID)) {
        try {
            // Exibe a tela de carregamento
            Load()

            const id_chamado = PegarCampoValor("id_chamado");
            const id_alocar = PegarCampoValor("id_alocar");
            const laudo_form = PegarCampoValor("laudo")

            const dadosEnviar = {
                id_tec: CodigoLogado(),
                id_chamado: id_chamado,
                id_alocar: id_alocar,
                laudo: laudo_form,
                endpoint: API_FINALIZAR_CHAMADO
            };

            // Chamada API para finalizar o chamado
            const response = await fetch(BASE_URL_API(), {
                method: "POST",
                headers: HEADER_COM_AUTENTICACAO(),
                body: JSON.stringify(dadosEnviar)
            });

            // Se houver erro na resposta da API, lança exceção
            if (!response.ok) {
                throw new Error(MSG_ERRO_CALL_API);
            }

            // Converte a resposta em JSON
            const objDados = await response.json();

            // Verifica se o usuário está autorizado
            if (objDados.result == NAO_AUTORIZADO) {
                Sair(); // Sair se não autorizado
                return;
            }

            // Exibe mensagem de sucesso ou erro
            if (objDados.result === 1) {
                MensagemApiJS(MSG_SUCCESSO, COR_MSG_SUCESSO);
                FecharModal("modal-chamados");
                FiltrarChamado(); // Recarrega a lista de chamados
            } else {
                MensagemApiJS(MSG_ERRO, COR_MSG_ERROR);
            }

        } catch (error) {
            // Mensagem de erro caso haja problema na API
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            // Remover o carregamento da tela
            RemoverLoad();
        }
    }

}

// Função para determinar a situação de um chamado
function VerSituacao(data_atendimento, data_encerramento) {

    let situacao = '';

    if (data_atendimento == null) {
        situacao = AGUARDANDO_ATENDIMENTO;
    } else if (data_encerramento != null) {
        situacao = ATENDIMENTO_ENCERRADO;
    } else if (data_atendimento != null && data_encerramento == null) {
        situacao = EM_ATENDIMENTO;
    }

    return situacao;
}
