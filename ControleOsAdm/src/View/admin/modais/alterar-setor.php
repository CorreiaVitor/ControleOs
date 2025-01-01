<div class="modal fade" id="modal-alterar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar o Setor Cadastrado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="nome_alterar">Setor Cadastrado:</label>
                <input type="hidden" name="id_alterar" id="id_alterar">
                <input name="nome_alterar" id="nome_alterar" class="form-control obg" placeholder="Digite o setor...">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline-success" onclick="AlterarSetorEquipamentoAjax('formALT')">Confirmar</button>
            </div>
        </div>

    </div>

</div>