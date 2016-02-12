<?php

/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */
//Adiciona Controle de Sessao
include_once 'controleSessao.php'; //include do banco

function sessao_login($post_recebido){
    $email = $post_recebido['email'];
    $senha = $post_recebido['senha'];
    
    if ($email=='admin@admin.com.br'){
        if ($senha=='123'){
        //passou
            //gravar a sessao
            sessao_grava($email);
            //redirecionar a pessoa para a home
            header("Location: home.php");
            
    }else{
        //nao passou pela senha
         header("Location: login.php?erro=login");
    }
    }else{
        //nao passou pelo email
         header("Location: login.php?erro=login");
    }
    
}

//Comeco do script
//var_dump($_POST);
if (isset($_POST['email'])){
sessao_login($_POST);
}



