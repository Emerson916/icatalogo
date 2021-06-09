<?php
session_start();
require("../database/conexao.php");


    $sql = " SELECT p.*, c.descricao as categoria FROM tbl_produto p
            INNER JOIN tbl_categoria c ON p.categoria_id = c.id ";
    
    if(isset($_GET["p"])&& $_GET["p"] != ""){
        $p = $_GET["p"];
        $sql .= " WHERE p.descricao LIKE '%$p%' OR c.descricao LIKE '%$p%' ";
    }
        $sql.= " ORDER BY p.id DESC ";   
          

$resultado = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

//mySqli_num_rows -- conta as linhas do MySqli
   
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
            <?php
                while ($produto = mysqli_fetch_array($resultado)){
                    if($produto["valor"] > 0){
                        $desconto = $produto["desconto"] / 100;
                        $novoValor = $produto["valor"] - $desconto * $produto["valor"];
                    }else{
                        $novovalor = $produto["valor"];
                    }

                    $qtdDeparcelas = $novoValor > 1000 ? 12 : 6;
                    $valorParcela = $novoValor / $qtdDeparcelas;
                    $valorParcela = number_format($valorParcela, 2, ",", ".");
                ?>
                    <article class="card-produto">
                        <?php
                        if(isset($_SESSION["usuarioId"])){
                        ?>

                        <div class="acoes">
                             <img onClick="javascript: window.location = './editar/index.php?id=<?= $produto['id']?>'" src="../imgs/edit.png" />
                            <img onClick="deletar(<?= $produto['id'] ?>)" src="../imgs/trash.png" />
                        </div>
                        <?php
                        }
                        ?>
                        <figure>
                            <img src="fotos/<?= $produto["imagem"] ?>"/>
                        </figure>
                        <section>
                            <span class="preco">R$<?=number_format($novoValor ,2 ,"," ,".") ?>
                                <?php
                                if ($produto["desconto"] > 0) {
                                ?>
                                <em>
                                    <?= $produto["desconto"] ?> % off
                                </em>
                                <?php
                                }
                                ?>
                            </span>
                            
                            <span class="parcelamento"> ou em <em><?= $qtdDeparcelas ?> x R$ <?= $valorParcela ?> sem juros</em></span>

                            <span class="descricao"><?= $produto["descricao"] ?> </span>
                            <span class="categoria">
                                <em><?= $produto["categoria"] ?></em>
                            </span>
                        </section>
                        <footer>

                        </footer>
                    </article>
                <?php
                }
                ?>
                <form id="formDeletar" method="POST" action="./acoes.php">
                    <input type="hidden" name="acao" value="deletar">
                    <input id="produtoId" type="hidden" name="produtoId" />
                </form>
            </main>
        </section>
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>
    <script lang="javascript">
        function deletar(produtoId){
            if(confirm("Deseja realmente excluir este produto ?")){
            document.querySelector("#produtoId").value = produtoId;
            document.querySelector("#formDeletar").submit();
            }
        }
    </script>    
</body>

</html>