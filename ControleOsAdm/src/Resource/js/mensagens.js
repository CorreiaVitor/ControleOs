function mensagensJS(ret) {

//Arquivos de msg em javascript
    if(ret == 0){
        toastr.warning('Preencha todos os campos obrigatórios!');
    }else if (ret == 1){
        toastr.success('Ação concluída com sucesso!');
    }else if (ret == -1){
        toastr.error('Ocorreu uma erro. Tente novamente mais tarde');
    }else if (ret == -2){
        toastr.info('Nenhum resultado encontrado.');
    }else if (ret == -3){
        toastr.warning('CEP não encontrado');
    }else if (ret == -4){
        toastr.info('Formato do CEP inválido');
    }else if (ret == -5){
        toastr.info('CPF inválido');
    }else if (ret == -6){
        toastr.info('E-mail inválido');
    }else if (ret == -7){
        toastr.error('E-mail já cadastrado');
    }else if (ret == -8){
        toastr.info('E-mail inválido');
    }else if (ret == -9){
        toastr.info('Usuário não encontrado!');
    }else if (ret == -10){
        toastr.info('!');
    }else if (ret == -11){
        toastr.info('CPF já cadastrado.');
    }
}