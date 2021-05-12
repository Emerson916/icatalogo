<?php

//obs: Criptografia tem retorno

// Testando os hashs

//obs: Hashs, não tem retorno

echo md5("1234");

echo "<br/><br/>";

echo sha1("1234");

echo "<br/><br/>";

//Recomendado utilizar o password_hash

echo password_hash("1234", PASSWORD_DEFAULT);

