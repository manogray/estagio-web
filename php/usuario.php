<?php
	session_start();
	include("conexao.php");

	class Usuario {
		public $ID;
		public $Nickname;
		public $Email;
		private $Senha;

		public function __construct($Nickname,$Email,$Senha){
			$this->Nickname = $Nickname;
			$this->Email = $Email;
			$this->Senha = md5($Senha);
		}

		public function registrarUsuario($mysql){
			$resultVerificador = $mysql->query("SELECT nickname, email FROM usuario WHERE nickname = '$this->Nickname' || email = '$this->Email'");
			$Verificador = $resultVerificador->num_rows;
			if($Verificador == 0){
				$mysql->query("INSERT INTO `usuario` (nickname,email,senha) VALUES ('$this->Nickname','$this->Email','$this->Senha')");
				echo "<script>sessionStorage.setItem('UsuarioLogado',".$this->Nickname.")</script>";
				echo "<script>alert('Registro feito com sucesso!');</script>";
				echo "<meta http-equiv='refresh' content='0,url=/'>";
			}else {
				echo "<script>alert('Nickname ou Email já em uso!');</script>";
				echo "<meta http-equiv='refresh' content='0,url=/entrar.html'>";
			}
		}

		public function logarUsuario($mysql){
			$resultVerificador = $mysql->query("SELECT nickname FROM usuario WHERE nickname = '$this->Nickname' AND senha = '$this->Senha'");
			$Verificador = $resultVerificador->num_rows;
			if($Verificador == 1){
				echo "<script>sessionStorage.setItem('UsuarioLogado','".$this->Nickname."')</script>";
				echo "<meta http-equiv='refresh' content='0,url=/'>";
			}else {
				echo "<script>alert('Nickname ou Senha inválida!');</script>";
				echo "<meta http-equiv='refresh' content='0,url=/entrar.html'>";
			}
		}
	}

	if($_POST['modo'] == "entrar"){
		if(!empty($_POST['nickname']) && !empty($_POST['senha'])){
			$UsuarioLogado = new Usuario($_POST['nickname'],"",$_POST['senha']);
			$UsuarioLogado->logarUsuario($mysqli);
		}
	}

	if($_POST['modo'] == "registrar"){
		if(!empty($_POST['nickname']) && !empty($_POST['senha']) && !empty($_POST['confirmarSenha']) && !empty($_POST['email'])){

			$resultProximoID = $mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'noticia' AND table_schema = 'comicsnews'");
        	$ProximoID = $resultProximoID->fetch_assoc();

			$NovoUsuario = new Usuario($_POST['nickname'],$_POST['email'],$_POST['senha']);
			$NovoUsuario->ID = $ProximoID['AUTO_INCREMENT'];

			$NovoUsuario->registrarUsuario($mysqli);
		}	
	}
?>