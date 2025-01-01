<div class="modal fade" id="modal-dados-descarte">
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h5 class="modal-title">Dados do equipamento descartado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong >Equipamento: <span style="color: #282A3A;" id="infoEquipamento"></span></strong>
            </div>
            <div class="modal-body">
                <label for="data_descarte">Data Descarte</label>
                <input disabled type="date" id="dataDescarte" class="form-control" placeholder="Digite o modelo de equipamento...">
            </div>
            <div class="modal-body">
                <label for="nome_descarte">Motivo Descarte</label>
                <textarea readonly id="motivoDescarte" maxlength="100" class="form-control" placeholder="Digite o modelo de equipamento..."></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <!-- <button type="button" class="btn btn-outline-success" name="btn_descarte" onclick="DescartarEquipamento('formALT')">Confirmar</button> -->
            </div>
        </div>

    </div>

</div>