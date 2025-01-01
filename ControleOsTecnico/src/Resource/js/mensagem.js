function MensagemApiJS(msg, cor) {

    switch (cor) {
        case COR_MSG_ERROR:
            toastr.error(msg);
            break;

        case COR_MSG_ATENCAO:
            toastr.warning(msg);
            break;

        case COR_MSG_SUCESSO:
            toastr.success(msg);
            break;

        case COR_MSG_INFO:
            toastr.info(msg);
            break;
    }
}