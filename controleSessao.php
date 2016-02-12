<?php
session_start();
/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */
function sessao_grava($email){
    //crio um control
    $_SESSION['usuario']['email']=$email;
}


function sessao_valida(){
    $retorno =false;

    if ( isset($_SESSION['usuario']) ){        
        $retorno =true;
    }else{
        //echo "NAO existe";
        // fazer log
        //email do administrador etc...        
         header('Location: erro.php?motivo=sem_sessao');
        
    }
  
    
    return $retorno;
    
}

function sessao_limpa(){
    unset($_SESSION['usuario']);
   
}

function sessao_checa(){
    
}

