//#region FUNÇÕES API
function BASE_URL_API() {
    return "http://localhost/ControleOs/ControleOsAdm/src/Resource/api/tecnico_api.php";
}

function HEADER_SEM_AUTENTICACAO() {

    const header = {
        "Content-Type": "application/json"
    };

    return header;
}

function HEADER_COM_AUTENTICACAO() {

    const header = {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + GetTnk(),
    };

    return header; 

}

function CodigoLogado() {
    const dados = GetTnkValue();
    return dados.cod_user;
}

//#endregion

//#region FUNÇÕES GENERICAS DO PROJETO

function BASE_URL_INTRANET() {
    return "http://localhost/ControleOs/ControleOsTecnico/src/View/";
}

function HabilitarCampo(id, bool_habilitado) {
    if(bool_habilitado){
        document.getElementById(id).removeAttribute("disabled");
    }else{
        document.getElementById(id).setAttribute("disabled", "");
    }
}

function RedirecionarPag(page) {

    window.location = BASE_URL_INTRANET() + page + '.php';

}

function MostrarElemento(id, mostrar) {
    if(mostrar){
        document.getElementById(id).classList.remove("d-none");
    }else{
        document.getElementById(id).classList.add("d-none");
    }
}

function ValidarCamposJS(formID) {

    let ret = true;

    document.querySelectorAll(`#${formID} input, #${formID} textarea, #${formID} select`).forEach((elemento) => {

        if (elemento.classList.contains("obg")) {

            if (elemento.value === "") {
                ret = false;
                elemento.classList.add("is-invalid");
            } else {
                elemento.classList.remove("is-invalid");
                elemento.classList.add("is-valid");
            }
        }
    });

    if (!ret)

    MensagemApiJS(MSG_CAMPO_VAZIO, COR_MSG_ATENCAO);

    return ret;
}

async function ValidarCamposJSAsync(formID) {

    let ret = true;

    document.querySelectorAll(`#${formID} input, #${formID} textarea, #${formID} select`).forEach((elemento) => {

        if (elemento.classList.contains("obg")) {

            if (elemento.value === "") {
                ret = false;
                elemento.classList.add("is-invalid");
            } else {
                elemento.classList.remove("is-invalid");
                elemento.classList.add("is-valid");
            }
        }
    });

    if (!ret)

        MensagemApiJS(MSG_CAMPO_VAZIO, COR_MSG_ATENCAO);

    return ret;
}

async function LimparNotificacoesAsync(formID) {

    document.querySelectorAll(`#${formID} input, #${formID} textarea, #${formID} select`).forEach((elemento) => {
        elemento.value = '';
        elemento.classList.remove('is-invalid');
        elemento.classList.remove('is-valid');
    });
}

function LimparNotificacoes(formID) {

    document.querySelectorAll(`#${formID} input, #${formID} textarea, #${formID} select`).forEach((elemento) => {
        elemento.value = '';
        elemento.classList.remove('is-invalid');
        elemento.classList.remove('is-valid');
    })
}

function FecharModal(nome_modal) {

    $("#" + nome_modal).modal("hide")

}

function Load() {
    $(".loader").addClass("is-active");
}

function RemoverLoad() {
    $(".loader").removeClass("is-active");
}

function SetarCampoValor(id, value) {
    document.getElementById(id).value = value;
}

function PegarCampoValor(id) {
    return document.getElementById(id).value;
}
//#endregion

//#region FUNÇÕES JWT 

function AddTnk(t) {
    localStorage.setItem('user_tkn', t);
}

function GetTnkValue() {
    var token = GetTnk();
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var j = decodeURIComponent(window.atob(base64).split('').map(function
        (c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);

    }).join(''));
    return JSON.parse(j);
}

function GetTnk() {
    if (localStorage.getItem('user_tkn') != null)
        return localStorage.getItem('user_tkn');
}

function setNomeLogado(nome) {
    localStorage.setItem("nome_logado", nome);
}
function getNomeLogado() {
    return localStorage.getItem("nome_logado");
}

function MostrarNomeLogin() {
    if (localStorage.getItem('nome_logado') != null)
        document.getElementById("nome_logado").innerHTML =
            getNomeLogado();
}

function ClearTnk() {
    localStorage.clear();
}

function Sair() {
    ClearTnk();
    RedirecionarPag('acesso/login');
}

function Verify() {
    if (localStorage.getItem('user_tkn') === null)
        Sair();
}
//#endregion
