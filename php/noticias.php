<?php
	include("conexao.php");

	//ENDERECO USADO PARA O UPLOAD DE ARQUIVOS
	$ENDERECOLOCAL = "C:/Users/manogray/Documents/estagio-web/img/";

	class Noticia {
		public $ID;
		public $Titulo;
		public $Descricao;
		public $Imagem;
		public $Data;
		public $Autor;

		public function __construct($Titulo, $Descricao, $Imagem, $Data, $Autor){
			$this->Titulo = $Titulo;
			$this->Descricao = $Descricao;
			$this->Imagem = $Imagem;
			$this->Data = $Data;
			$this->Autor = $Autor;
		}

		public function inserirNoticia($mysql){
			$mysql->query("INSERT INTO `noticia` (titulo,descricao,img,data,autor) VALUES ('$this->Titulo','$this->Descricao','$this->Imagem','$this->Data','$this->Autor')");
		}

		public function editarNoticia($IDNoticia,$mysql,$NovoTitulo,$NovoAutor,$NovaDescricao){
			if($NovoTitulo != $this->Titulo){
				$mysql->query("UPDATE `noticia` SET titulo = '$NovoTitulo' WHERE ID = '$IDNoticia'");
			}

			if($NovoAutor != $this->Autor){
				$mysql->query("UPDATE `noticia` SET autor = '$NovoTitulo' WHERE ID = '$IDNoticia'");
			}

			if($NovaDescricao != $this->Descricao){
				$mysql->query("UPDATE `noticia` SET descricao = '$NovoTitulo' WHERE ID = '$IDNoticia'");
			}

			echo "<meta http-equiv='refresh' content='0,url=/'>";			
		}
	}

	if(isset($_GET['loadnews'])){

		$resultNews = $mysqli->query("SELECT ID, titulo, descricao, img, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data, autor FROM noticia ORDER BY data DESC LIMIT 20");
		while($linhaNews = $resultNews->fetch_assoc()) {
			$NovaNoticia = new Noticia($linhaNews['titulo'],$linhaNews['descricao'],$linhaNews['img'],$linhaNews['data'],$linhaNews['autor']);
			$NovaNoticia->ID = $linhaNews['ID'];

			$UltimasNoticias[] = $NovaNoticia;	
		}

		echo json_encode($UltimasNoticias);

	}

	if(isset($_GET['detailnews'])){
		$IDNoticiaExibida = $_GET['detailnews'];
		$resultNews = $mysqli->query("SELECT ID, titulo, descricao, img, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data, autor FROM noticia WHERE ID = '$IDNoticiaExibida'");
		$linhaNews = $resultNews->fetch_assoc();

		$NoticiaExibida = new Noticia($linhaNews['titulo'],$linhaNews['descricao'],$linhaNews['img'],$linhaNews['data'],$linhaNews['autor']);
		$NoticiaExibida->ID = $linhaNews['ID'];

		echo json_encode($NoticiaExibida);
	}

	if(isset($_GET['deletenews'])){
		$IDNoticiaDelete = $_GET['deletenews'];
		$resultNews = $mysqli->query("SELECT img FROM `noticia` WHERE ID = '$IDNoticiaDelete'");
		$linhaNews = $resultNews->fetch_assoc();
		$IMG = $linhaNews['img'];

		if($mysqli->query("DELETE FROM `noticia` WHERE ID = '$IDNoticiaDelete'")){
			unlink($ENDERECOLOCAL.$IMG);
			echo "<script>location.href = '/'</script>";
		}else {
			echo "<script>alert('Ocorreu algum erro');</script>";
		}
	}

	if(isset($_POST['origem']) && $_POST['origem'] == "editorNoticia"){
		$IDNoticiaEditada = $_POST['idNoticia'];
		$resultNews = $mysqli->query("SELECT ID, titulo, descricao, img, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data, autor FROM noticia WHERE ID = '$IDNoticiaEditada'");
		$linhaNews = $resultNews->fetch_assoc();

		$NoticiaEditada = new Noticia($linhaNews['titulo'],$linhaNews['descricao'],$linhaNews['img'],$linhaNews['data'],$linhaNews['autor']);
		$NoticiaEditada->ID = $linhaNews['ID'];
		$NoticiaEditada->editarNoticia($IDNoticiaEditada,$mysqli,$_POST['titulo'],$_POST['autor'],$_POST['descricao']);
	}

	if(isset($_POST['origem']) && $_POST['origem'] == "cadastroNoticia"){

		if($_FILES['imagem']['error'] != 0){
			die("Ocorreu um erro!");
			exit;
		}

		$resultProximoID = $mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'noticia' AND table_schema = 'comicsnews'");
        $ProximoID = $resultProximoID->fetch_assoc();

		if( preg_match('@\.(jpg|png|gif|jpeg|bmp)$@i', $_FILES['imagem']['name'], $reg) ){
		  if( preg_match('@image/(\w+)@i', $_FILES['imagem']['type'], $reg_type) ){
			
		  	$nomeImagem = $ProximoID['AUTO_INCREMENT']."-".$_FILES['imagem']['name'];
		  	$DataAtual = date("Y-m-d H:i:s");
		  	if(move_uploaded_file($_FILES['imagem']['tmp_name'], $ENDERECOLOCAL.$nomeImagem)){
		  		$NovaNoticia = new Noticia($_POST['titulo'],$_POST['descricao'],"img/".$nomeImagem,$DataAtual,$_POST['autor']);
		  		$NovaNoticia->inserirNoticia($mysqli);
		  		echo "<script>alert('Noticia postada com sucesso!');</script>";
		  		echo "<meta http-equiv='refresh' content='0,url=/'>";
		  	}else{
		  		echo "<script>alert('Deu algo errado!')</script>";
		  		echo "<meta http-equiv='refresh' content='0,url=/cadastrar.html'>";
		  	}

		  }else {
		  	echo "<script>alert('Somente imagens são aceitadas para upload')</script>";
		  	echo "<meta http-equiv='refresh' content='0,url=/cadastrar.html'>";
		  }
		}
	}
?>