<div class="modal fade" id="modal-descarte">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Você realmente deseja descartar o equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Descartar o equipamento: <span style="color: #FF004D;" id="nome_equipamentos"></span></strong>
                <input type="hidden" name="id_equipamento" id="id_equipamento" class="form-control obg" placeholder="Digite o modelo de equipamento...">
            </div>
            <div class="modal-body">
                <label for="data_descarte">Data Descarte</label>
                <input type="date" name="data_descarte" id="data_descarte" class="form-control obg" placeholder="Digite o modelo de equipamento...">
            </div>
            <div class="modal-body">
                <label for="nome_descarte">Motivo Descarte</label>
                <textarea name="motivo_descarte" id="motivo_descarte" maxlength="100" class="form-control obg" placeholder="Digite o modelo de equipamento..."></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline-success" name="btn_descarte" onclick="DescartarEquipamentoAjax('formALT')">Confirmar</button>
            </div>
        </div>

    </div>

</div>