// Função para carregar equipamentos de um setor
async function CarregarEquipamentoSetor() {
    const dadosEnviar = {
        endpoint: API_LISTAR_EQUIPAMENTO_SETOR,
        id_setor: CodigoSetorLogado()
    };

    try {
        Load(); // Exibe o loader enquanto a operação é processada

        const response = await fetch(BASE_URL_API(), {
            method: "POST",
            headers: HEADER_COM_AUTENTICACAO(),
            body: JSON.stringify(dadosEnviar)
        });

        if (!response.ok) {
            throw new Error(MSG_ERRO_CALL_API); // Lança erro em caso de resposta inválida
        }

        const objDados = await response.json();
        const equipamentos = objDados.result;

        if (equipamentos === NAO_AUTORIZADO) {
            Sair(); // Realiza logout caso o usuário não esteja autorizado
            return;
        }

        const combo_equipamento = document.getElementById("equipamento");
        combo_equipamento.innerHTML = "<option value=''>Selecione</option>";

        equipamentos.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id_alocar;
            opt.text = `${item.nome_tipo} / ${item.nome_modelo} / Identificação: ${item.identificacao}`;
            combo_equipamento.appendChild(opt);
        });

    } catch (error) {
        MensagemApiJS(error.message, COR_MSG_ERROR); // Exibe mensagem de erro
    } finally {
        RemoverLoad(); // Remove o loader
    }
}

// Função para abrir um chamado
async function AbrirChamado(formID) {
    if (await ValidarCamposJS(formID)) {
        const dadosEnviar = {
            endpoint: API_ABRIR_CHAMADO,
            id_alocar: PegarCampoValor("equipamento"),
            funcionario_id: CodigoLogado(),
            problema: PegarCampoValor("problema")
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
                MensagemApiJS(MSG_SUCCESSO, COR_MSG_SUCESSO); // Mensagem de sucesso
                await LimparNotificacoes(formID);
                await CarregarEquipamentoSetor();
            } else {
                MensagemApiJS(MSG_ERRO, COR_MSG_ERROR); // Mensagem de erro
            }

        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            RemoverLoad();
        }
    }
}

// Função para detalhar um chamado
async function DetalharChamado(id_chamado) {
    if (id_chamado !== "") {
        const dadosEnviar = {
            endpoint: API_DETALHAR_CHAMADO,
            id: id_chamado
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
            const chamado = objDados.result;

            if (chamado === NAO_AUTORIZADO) {
                Sair();
                return;
            }

            // Preenche os campos com os dados do chamado
            SetarCampoValor("equipamento", `${chamado.nome_tipo} / ${chamado.nome_modelo} / ${chamado.identificacao}`);
            SetarCampoValor("data_abertura", chamado.data_abertura);
            SetarCampoValor("problema", chamado.problema);
            SetarCampoValor("id_chamado", chamado.id_chamado);
            SetarCampoValor("id_alocar", chamado.id_alocar);
            SetarCampoValor("tec_ini", chamado.tecnico_atendimento);
            SetarCampoValor("data_atendimento", chamado.data_atendimento);
            SetarCampoValor("laudo", chamado.laudo);
            SetarCampoValor("data_encerramento", chamado.data_encerramento);
            SetarCampoValor("tec_fina", chamado.tecnico_finalizado);

        } catch (error) {
            MensagemApiJS(error.message, COR_MSG_ERROR);
        } finally {
            RemoverLoad();
        }
    }
}

// Função para filtrar chamados
async function FiltrarChamado() {
    MostrarElemento("resultado", false);

    const dadosEnviar = {
        endpoint: API_FILTRAR_CHAMADO,
        situacao: PegarCampoValor("situacao"),
        id_setor: CodigoSetorLogado()
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
        const chamados = objDados.result;

        if (chamados === NAO_AUTORIZADO) {
            Sair();
            return;
        }

        if (chamados.length === 0) {
            MensagemApiJS(MSG_DADOS_NAO_ENCONTRADO, COR_MSG_INFO);
            return;
        }

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
                            </thead><tbody>`;

        let data_tr = '';
        chamados.forEach(item => {
            const situacao = VerSituacao(item.data_atendimento, item.data_encerramento);
            data_tr += `<tr>
                            <td>${item.tecnico_atendimento !== null ? `<a href="#" data-toggle="modal" onclick="DetalharChamado(${item.id_chamado})" data-target="#modal-chamados" class="btn btn-warning btn-xs">Ver detalhes</a>` : ''}</td>
                            <td>${item.data_abertura}</td>
                            <td>${situacao}</td>
                            <td>${item.funcionario}</td>
                            <td>${item.nome_tipo} / ${item.nome_modelo} / ${item.identificacao}</td>
                            <td>${item.problema}</td>
                        </tr>`;
        });

        tab_content += data_tr;
        tab_content += "</tbody>";
        tab_result.innerHTML = tab_content;
        MostrarElemento("resultado", true);

    } catch (error) {
        MensagemApiJS(error.message, COR_MSG_ERROR);
    } finally {
        RemoverLoad();
    }
}

// Função para verificar a situação do chamado
function VerSituacao(data_atendimento, data_encerramento) {
    if (data_atendimento === null) {
        return AGUARDANDO_ATENDIMENTO;
    } else if (data_encerramento !== null) {
        return ATENDIMENTO_ENCERRADO;
    } else if (data_atendimento !== null && data_encerramento === null) {
        return EM_ATENDIMENTO;
    }
}
