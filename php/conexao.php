<?php

  $target="conexao.php";
  if(basename($_SERVER["PHP_SELF"])== $target){
    die("<meta charset='utf-8'><title></title><script>window.location=('index.html')</script>");
  }
  
  global $servidor;
  $servidor = "localhost";
  global $usuario;
  $usuario = "root";
  global $senha;
  $senha = "281295";
  global $banco;
  $banco = "comicsnews";

  global $mysqli;

  $mysqli = new mysqli($servidor,$usuario,$senha,$banco);

  if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

  date_default_timezone_set("America/Manaus");

  $mysqli->set_charset('utf8');

?>