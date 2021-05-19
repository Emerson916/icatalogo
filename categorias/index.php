<?php

session_start();

// Para evitar que acesse a página pela URL, precisa estar conectado!!

if(!isset($_SESSION["usuarioId"])){
    $_SESSION["mensagem"] = "você precisa fazer login";

    header("location: ../produtos");

    exit();

}
require("../database/conexao.php");

$sql = " SELECT * FROM tbl_categoria";

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
                    <button type="button" onclick="javascript: window.location.href='../produtos'">Cancelar</button>
                    <button>Salvar</button>
                </form>


                <h1>Lista de categorias</h1>
                <?php
                //mySqli_num_rows -- conta as linhas do MySqli
                if(mysqli_num_rows($resultado) == 0){
                    echo"<center>Nenhuma categoria cadastrada</center>";
                }

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

                <!-- ***outra maneira de apagar as categorias, com JavaScript***

                <form id="form-deletar" method="POST" action="./actions.php">
                    <input type="hidden" name="acao" value="excluir"/>
                    <input id="categoria-id" type="hidden" name="categoriaId" value=""/>
            
                </form>
                -->

            </main>
        </section>
    </div>

    <!-- ***outra maneira de apagar as categorias, com JavaScript***

    <script lang="javascript">
        function excluir(categoriaId){
            //coloca o id da categoria no input hidden categoria-id
            document.querySelector("#categoria-id").value = categoriaId;

            //eviar o formulário de delesão
            document.querySelector("#form-deletar").submit();
        }

        ***colocar essa parte da img no formulário de delesão***

        <onclick="deletar"(< ? = $categoria['id'] ?>) img src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png"/>
    </script>
    -->
</body>
</html>