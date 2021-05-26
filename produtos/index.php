<?php


require("../database/conexao.php");

$sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
        INNER JOIN tbl_categoria c ON p.categoria_id = c.id
        ORDER BY p.id DESC";

$resultado = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

//Terminar****
//percorrer os resultados

//mySqli_num_rows -- conta as linhas do MySqli
    if(mysqli_num_rows($resultado) == 0){
        echo"<center>Nenhuma categoria cadastrada</center>";
    }

    while ($produto = mysqli_fetch_array($resultado)) {
    ?>
    <article class="card-produto">
        <figure>
            <img src="http://3.bp.blogspot.com/-u34_1MW1w5g/T_eNqYLmtFI/AAAAAAAAEP0/jnssgMNcS8Y/s1600/converse-all-star-dark-blue.png" />
        </figure>
            <section>
                <span class="preco"><?=$valor['valor']?></span>
                <span class="parcelamento">ou em <em>10x R$100,00 sem juros</em></span>

                <span class="descricao">Produto xyz cor preta novo perfeito estado 100%</span>
                <span class="categoria">
                    <em>Calçados</em>
                </span>
        </section>
        <footer>

        </footer>
    </article>
    <?php
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./produtos.css" />
    <title>Administrar Produtos</title>
</head>

<body>
    <?php
    include("../componentes/header/header.php");
    ?>
    <div class="content">
    <div style="position:absolute; top:0; right:0">
            <?php
            if(isset($_SESSION["mensagem"])){
                echo $_SESSION["mensagem"];
            
                unset($_SESSION["mensagem"]);
            }
            ?>
        </div>
        <section class="produtos-container">
            <?php
            //mostrar os botões somente caso o usuário esteja logado
            if(isset($_SESSION["usuarioId"])){
              
            ?>
            
            <header>
                <button onclick="javascript:window.location.href ='./novo/'">Novo Produto</button>
                <button onclick="javascript:window.location.href ='../categorias'">Adicionar Categoria</button>
            </header>
            <?php
            }
            ?>
            
            <main>
                <article class="card-produto">
                    <figure>
                        <img src="http://3.bp.blogspot.com/-u34_1MW1w5g/T_eNqYLmtFI/AAAAAAAAEP0/jnssgMNcS8Y/s1600/converse-all-star-dark-blue.png" />
                    </figure>
                    <section>
                        <span class="preco">R$ 1000,00</span>
                        <span class="parcelamento">ou em <em>10x R$100,00 sem juros</em></span>

                        <span class="descricao">Produto xyz cor preta novo perfeito estado 100%</span>
                        <span class="categoria">
                            <em>Calçados</em>
                        </span>
                    </section>
                    <footer>

                    </footer>
                </article>
            </main>
        </section>
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>
</body>

</html>