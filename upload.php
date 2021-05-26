<?php

    function validaCampos(){
        $erros = [];

        //Se não houver alguem aquivo no campo imagem
        if($_FILES["imagem"]["error"] == UPLOAD_ERR_NO_FILE){
            $erros[] = "O campo imagem é obrigatório";
        
        //se houver algum erro no upload
        }elseif(!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] != UPLOAD_ERR_OK){

            $erros[] = "Ops, houve um erro inesperado, verigique o arquivo e tente novamente";

        }else{
            //pegamos as irformações de imagem
            $imagemInfos = getimagesize($_FILES["imagem"]["tmp_name"]);

            //se não for uma imagem
            if(!$imagemInfos){
                $erros[] = "O arquivo precisa ser uma imagem";
            }

            //se a imagem for maior que 1MB
            if($_FILES["imagem"]["size"] > 1024 * 1024){
                $erros[] = "O arquivo não pode ser maior que 1MB";
            }

        }

        return $erros;
    }

    $erros = validaCampos();

    if(count($erros) > 0){
        echo $erros[0];

        exit();
    }

//     $a = getimagesize($_FILES["imagem"]["tmp_name"]);

// echo $a[0]."<br>";
// echo $a[1]."<br>";

// $a[0] = 200;
// $a[1] = 200;
// echo $a[0]."<br>";
// echo $a[1]."<br>";

// print_r($_FILES);

// $_FILES["imagem"]["size"] = 1024;

// print_r($_FILES);

// exit();

    //recuperamos o nome original do arquivo
    $nomeArquivo = $_FILES["imagem"]["name"];

    //recuperamos a extensão do aqruivo
    $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

    //geramos um novo nome único e colocamos a extensão original
    $novoNomeArquivo = md5(microtime()) . ".$extensao";

    //movemos o arquivo para a pasta de destivo (/imagens)
    move_uploaded_file($_FILES["imagem"]["tmp_name"], "imagens/$novoNomeArquivo");

    //podemos salvar no banco de dados o novo nome do arquivo.
    //para que possamos mostar ele para os usuarios feturamente
    //da seguinte forma:

?>

<img src="imagens/<?=$novoNomeArquivo?>">