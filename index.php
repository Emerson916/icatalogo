<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de arquivos</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" action="upload.php">
        <input type="file" name="imagem" accept="image/*"/>
        <br/><br/>
        <button>Enviar</button>
    </form>
</body>
</html>