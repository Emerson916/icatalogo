<?php

//inicializa a sessão no php
//todo arquivo que utilizar sessão, precisa chamar a session_start()
session_start();

//validação vou fazer daqui a pouco
function validarCampos()
{
    //declara um vetor de erros
    $erros = [];

    //validar se campo descricao está preenchido
    if (!isset($_POST["descricao"]) && $_POST["descricao"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }

    //validar se o campo peso está preenchido
    if (!isset($_POST["peso"]) && $_POST["peso"] == "") {
        $erros[] = "O campo peso é obrigatório";
        //validar se o campo peso é um número
    } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
        $erros[] = "O campo peso deve ser um número";
    }

    //validar se o campo quantidade está preenchido
    if (!isset($_POST["quantidade"]) && $_POST["quantidade"] == "") {
        $erros[] = "O campo quantidade é obrigatório";
        //validar se o campo quantidade é um número
    } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
        $erros[] = "O campo quantidade deve ser um número";
    }

    if (!isset($_POST["cor"]) && $_POST["cor"] == "") {
        $erros[] = "O campo cor é obrigatório";
    }

    if (!isset($_POST["valor"]) && $_POST["valor"] == "") {
        $erros[] = "O campo valor é obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {
        $erros[] = "O campo valor deve ser um número";
    }

    //se o campo desconto veio preenchido, testa se ele é numérico
    if (isset($_POST["desconto"]) && $_POST["desconto"] != "" && !is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
        $erros[] = "O campo desconto deve ser um número";
    }

    //Validação de imagens

    //Se não houver alguem aquivo no campo foto
    if($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE){
        $erros[] = "O campo imagem/foto é obrigatório";
    
    //se houver algum erro no upload
    }elseif(!isset($_FILES["foto"]) || $_FILES["foto"]["error"] != UPLOAD_ERR_OK){

        $erros[] = "Ops, houve um erro inesperado, verigique o arquivo e tente novamente";

    }else{
        //pegamos as irformações de foto, na pasta "tmp_name" (pasta temporaria do xampp)

        // GetImagesize pega as informações da imagem

        $imagemInfos = getimagesize($_FILES["foto"]["tmp_name"]);

        //se não houver uma arquivo temporario de uma imagem, então dá erro, "tem que ser uma foto!!"
        if(!$imagemInfos){
            $erros[] = "O arquivo precisa ser uma imagem/foto";
        }

        //se a foto for maior que 2MB
        if($_FILES["foto"]["size"] > 1024 * 1024 * 2){
            $erros[] = "A foto não pode ser maior que 2MB";
        }

        //Verificando se a imagem é quadrada

        $width = $imagemInfos[0];
        $height = $imagemInfos[1];
        if($width != $$height){
            $erros[] = "A imagem precisa ser quadrada";
        }
    }

    //validação da categoria
    if(!isset($_POST["categoria"]) || $_POST["categoria"] == ""){
        $erros[] = "O campo categoria é obrigatorio, você deve selecionar uma!!";
    }

    //retorna os erros
    return $erros;
}

function validarCamposEditar()
{
    //declara um vetor de erros
    $erros = [];
    //validar se campo descricao está preenchido
    if (!isset($_POST["descricao"]) && $_POST["descricao"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }
    //validar se o campo peso está preenchido
    if (!isset($_POST["peso"]) && $_POST["peso"] == "") {
        $erros[] = "O campo peso é obrigatório";
        //validar se o campo peso é um número
    } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
        $erros[] = "O campo peso deve ser um número";
    }
    //validar se o campo quantidade está preenchido
    if (!isset($_POST["quantidade"]) && $_POST["quantidade"] == "") {
        $erros[] = "O campo quantidade é obrigatório";
        //validar se o campo quantidade é um número
    } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
        $erros[] = "O campo quantidade deve ser um número";
    }
    if (!isset($_POST["cor"]) && $_POST["cor"] == "") {
        $erros[] = "O campo cor é obrigatório";
    }
    if (!isset($_POST["valor"]) && $_POST["valor"] == "") {
        $erros[] = "O campo valor é obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {
        $erros[] = "O campo valor deve ser um número";
    }
    //se o campo desconto veio preenchido, testa se ele é numérico
    if (isset($_POST["desconto"]) && $_POST["desconto"] != "" && !is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
        $erros[] = "O campo desconto deve ser um número";
    }
    //validação da imagem
    if ($_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE) {
        $imagemInfos = getimagesize($_FILES["foto"]["tmp_name"]);
        if (!$imagemInfos) {
            $erros[] = "O arquivo precisa ser uma imagem";
        } elseif ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
            $erros[] = "A foto não pode ser maior que 2MB";
        }
        //verifica se a imagem é quadrada
        $width = $imagemInfos[0];
        $height = $imagemInfos[1];
        if ($width != $height) {
            $erros[] = "A imagem precisa ser quadrada";
        }
    }
    //validação da categoria
    if (!isset($_POST["categoria"]) || $_POST["categoria"] == "") {
        $erros[] = "O campo categoria é obrigatório, você deve selecionar uma";
    }
    //retorna os erros
    return $erros;
}


require("../database/conexao.php");

switch ($_POST["acao"]) {

    case "inserir":
        //chamamos a função de validação para verificicar se tem erros
        $erros = validarCampos();

        //var_dump($_FILES);

        //exit();

        //se houver erros
        if (count($erros) > 0) {

            //incluímos um campo erros na sessão e atribuímos o vetor de erros a ele
            $_SESSION["erros"] = $erros;

            //redireciona para a págino do formulário
            header("location: novo/index.php");
        }

        //Fazer o upload do arquivo/imagem
        $nomeArquivo = $_FILES["foto"]["name"];

        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        $novoNomeArquivo = md5(microtime()) . ".$extensao";

        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNomeArquivo");

        //recebemos os valores em variáveis
        $descricao = $_POST["descricao"];
        //precisamos trocar a vírgula do decimal por ponto
        //o bando de dados espera ponto no separador de decimal
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;
        $categoria = $_POST["categoria"];
        //declaramos o sql de insert no banco de dados
        $sqlInsert = " INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
                        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNomeArquivo', $categoria) ";

        echo $sqlInsert;

        //executamos o sql
        $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));

        //verificamos se deu certo ou não
        if ($resultado) {
            $mensagem = "Produto inserido com sucesso!";
        } else {
            $mensagem = "Erro ao inserir o produto!";
        }

        $_SESSION["mensagem"] = $mensagem;
        //redirecionamos para a página de listagem
        header("location: index.php");

        break;

    case 'deletar':
        $produtoId = $_POST["produtoId"];
//Procura a imagem no banco de dados id do produto
        $sqlImage = " SELECT imagem FROM tbl_produto WHERE id = $produtoId";
        $resultado = mysqli_query($conexao, $sqlImage);
        $produto = mysqli_fetch_array($resultado);
        //deletamos a imagem pelo nome 
        unlink("./imgs/" . $produto["imagem"]);

        $sql = " DELETE FROM tbl_produto WHERE id = $produtoId";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $mensagem = "Produto excluido com sucesso!";
        }else{
            $mensagem = "Ops, erro ao excluir!";
        }

        $_SESSION["mensagem"] = $mensagem;

        header("location: index.php");

        break;

    case "editar":

        $erros = validarCamposEditar();

        //se houver erros
        if(count($erros) > 0){

            //Incluimos um campo erros na sessão e atribuimos o vetor de erros a ele
            $_SESSION["erros"] = $erros;

            //redirecionamos para a pagina de formulario
            header("location: editar/index.php");

            exit();
        }

        $produtoId = $_POST["produtoId"];

        $descricao = $_POST["descricao"];
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;
        $categoria = $_POST["categoria"];

        $sql = " UPDATE tbl_produto SET descricao = '$descricao', peso = $peso,
        quantidade = $quantidade, cor = '$cor', tamanho = '$tamanho', 
        valor = $valor, desconto = '$desconto', categoria_id = $categoriaId
        WHERE id = $produtoId ";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $mensagem = "Produto editado com sucesso.";
        }else{
            $mensagem = "Ops, erro ao editar o produto.";
        }
        $_SESSION["mensagem"] = $mensagem;

        header("location: index.php");

        break;
}
