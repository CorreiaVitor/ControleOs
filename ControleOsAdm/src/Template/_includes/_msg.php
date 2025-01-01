<?php

//O arquivo PHP exibe mensagens com base no retorno da função JavaScript 'mensagensJS'.
if(isset($ret)){
    echo "<script>mensagensJS($ret)</script>";
}

?>