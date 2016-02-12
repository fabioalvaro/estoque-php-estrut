<?php 
//Adiciona Controle de Sessao
include_once 'controleSessao.php'; //include do banco
sessao_valida();

require_once 'comum/topo.php'; ?>
        <div>
            <h1>Gerar Relatorio Departamentos</h1>
            <a href="lista_dep.php">Gerar Relatorio</a>
            
        </div>
<?php require_once 'comum/base.php'; ?>
