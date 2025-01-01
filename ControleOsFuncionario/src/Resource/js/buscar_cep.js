function habilitarCampos(flag) {
    $("#cidade").prop("disabled", flag);
    $("#estado").prop("disabled", flag);
}

function limparFormularioCep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('estado').value = ("");
    document.getElementById('cep').value = ("");
    $("#cep").focus();

}

function meuCallback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('estado').value = (conteudo.uf);
        habilitarCampos(true);
    } //end if.
    else {
        //CEP não Encontrado.
        habilitarCampos(false);
        limparFormularioCep();
        MensagemApiJS(MSG_NAO_ENCONTRADO ,COR_MSG_INFO);
    }
}

function pesquisaCep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('estado').value = "...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meuCallback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limparFormularioCep();
            MensagemApiJS(MSG_CEP_NAO_ENCONTRADO ,COR_MSG_INFO);
            habilitarCampos(true);
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limparFormularioCep();
    }
};