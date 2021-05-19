<?php


require("../database/conexao.php");

$sql = " SELECT * FROM tbl_categoria ";

$resultado = mysqli_query($conexao, $sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./categorias.css" />
    <title>Administrar Categorias</title>
</head>
<body>
    <?php
        include("../componentes/header/header.php");
    ?>

    <div class="content">
        <section class="categorias-container">
            <main>
                <form method="POST" action="actions.php">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <div class="input-group span2">
                        <input type="hidden" name="acao" value="inserir"/>
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" placeholder="Digite uma descrição"/>
                    </div>
                    <button type="button">Cancelar</button>
                    <button>Salvar</button>
                </form>


                <h1>Lista de categorias</h1>
                <?php
                 while ($descricao = mysqli_fetch_array($resultado)) {
                ?>
                <form method="POST" action="actions.php">
                <input type="hidden" name="acao" value="excluir"/>
                <input type="hidden" name="descricaoId" value="<?= $descricao["id"] ?>" />
                    
                        <div class="card-categorias">
                        <?= $descricao["descricao"] ?>
                        <button>
                        <img src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png"/>
                        </button>
                        </div>
                </form>
                <?php
                 }
                ?>
            </main>
        </section>
    </div>
</body>
</html>