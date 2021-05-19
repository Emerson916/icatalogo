<?php
session_start();

require("../database/conexao.php");

function validarCampos(){
    $erros = [];

    if(!isset($_POST["descricao"]) || $_POST["descricao"] == ""){
        $erros[] = "O campo descrição é obrigatorio";
    }
    return $erros;
}

switch($_POST["acao"]) {

    case 'inserir':

        $erros = validarCampos();

        if(count($erros) > 0){
            $_SESSION["mensagem"] = $erros[0];

            header("location: index.php");

            exit();
        }

        if(isset($_POST["descricao"])){
            $descricao =  $_POST["descricao"];
     
             $InsertSql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao')";
     
             $resultado = mysqli_query($conexao, $InsertSql) or die (mysqli_error($conexao));
        
     
            if($resultado){
                $_SESSION["mensagem"] = "Descricão adicionada com sucesso!";
            }else{
                $_SESSION["mensagem"] = "Erro ao adicionar descrição!";
            }
        }
    break;

    case 'excluir':
        if (isset($_POST["descricaoId"])) {
            $descricaoId = $_POST["descricaoId"];

            
            $sqlDelete = "DELETE FROM tbl_categoria WHERE id = '$descricaoId'";

            
            $resultado = mysqli_query($conexao, $sqlDelete);

            if($resultado){
                $_SESSION["mensagem"] = "Descrição excluída com sucesso!";
              
            }else{
                $_SESSION["mensagem"] = "Erro ao excluir a descrição!";
             
            } 
        }
    break; 
}
header("location: index.php?mensagem=$mensagem");
?>