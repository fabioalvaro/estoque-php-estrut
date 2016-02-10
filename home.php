<?php session_start(); // Inicia a sessão ?>

<?php include_once 'comum/topo.php'; ?>
        <div>Inventory Control</div>
        <ol type="1">
            <li><a href="cad_estoque.php">cadastro de Estoques</a></li>
            <li><a href="cad_dep.php">cadastro de Departamentos</a></li>
            <li><a href="cad_prod.php">cadastro de produtos</a></li>
            <li><a href="cad_kardex.php">cadastro de Movimentação/kardex</a></li>
            <li><a href="central_relatorios.php">Central de Relatorios</a></li>
            <li><a href="index.php">Sair</a></li>

        </ol>

<?php include_once 'comum/base.php';
