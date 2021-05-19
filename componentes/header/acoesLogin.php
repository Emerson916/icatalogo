<?php
session_start();
require("../../database/conexao.php");


// função para verificação de erros
function validarCampos(){
    $erros = [];

    if(!isset($_POST["usuario"]) || $_POST["usuario"] == ""){
        $erros[] = "O campo usuário é obrigatorio";
    }

    if(!isset($_POST["senha"]) || $_POST["senha"] == ""){
        $erros[] = "O campo senha é obrigatorio";
    }
    return $erros;
}


switch ($_POST["acao"]) {

    case "login":
        
        $erros = validarCampos();

        if(count($erros) > 0){
            $_SESSION["erros"] = $erros;

            header("location: ../../produtos/index.php");
        }

        //receber os campos usuário e senha do post
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];
        //montar o sql select na tabela tbl_administrador

        //SELECT * FROM tbl_administrador WHERE usuario = $usuario;
        $mySqliSelect = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario'";
        //executar o sql
        $resultado =  mysqli_query($conexao, $mySqliSelect) or die(mysqli_error($conexao));

        $usuario = mysqli_fetch_array($resultado);
        //verificar se o usuário existe //verificar se a senha está correta
      
        //password_verify("senha sem hash", "senha com hash") -- como deve usar o password_verify
        if(!$usuario || !password_verify($senha, $usuario["senha"])){
            //se a senha estiver errada, criar uma mensagem de "usuário e/ou senha inválidos"
            $mensagem = "Usuário e/ou senha inválidos";
        }else{
            //se estiver correta, salvar o id e o nome do usuário na sessão $_SESSION
            $_SESSION["usuarioId"] = $usuario["id"];
            $_SESSION["usuarioNome"] = $usuario["nome"];

            $mensagem = "Bem vindo," . $usuario["nome"];
        }
        
        $_SESSION["mensagem"] = $mensagem;  
        //redirecionar para a tela de listagem de produtos
        header("location: ../../produtos/index.php");

        break;

    case "logout":
        //Destruir a sessão 
        session_destroy();
          //Redirecionar para a index de produtos
          header("location: ../../produtos/index.php");
        break;
}
