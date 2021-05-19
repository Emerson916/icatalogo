<?php

require("../database/conexao.php");

switch($_POST["acao"]) {

    case 'inserir':
        if(isset($_POST["descricao"])){
            $descricao =  $_POST["descricao"];
     
             $InsertSql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao')";
     
             $resultado = mysqli_query($conexao, $InsertSql);
        
     
            if($resultado){
                $mensagem = "Descricão adicionada com sucesso!";
            }else{
                $mensagem = "Erro ao adicionar descrição!";
            }
        }
    break;

    case 'excluir':
        if (isset($_POST["descricaoId"])) {
            $descricaoId = $_POST["descricaoId"];

            
            $sqlDelete = "DELETE FROM tbl_categoria WHERE id = '$descricaoId'";

            
            $resultado = mysqli_query($conexao, $sqlDelete);

            if($resultado){
                $mensagem = "Descrição excluída com sucesso!";
              
            }else{
                $mensagem = "Erro ao excluir a descrição!";
             
            } 
        }
    break; 
}
header("location: index.php?mensagem=$mensagem");
?>