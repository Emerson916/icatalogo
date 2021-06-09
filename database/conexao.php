<?php

const HOST = "localhost";
const USER = "root";
const PASSWORD = "bcd127";
const DATABASE = "icatalogo2";

$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ($conexao == false) {
    die(mysqli_connect_error());
}


//senha do bd do host
//AAk=@jhZ]72!v~RU