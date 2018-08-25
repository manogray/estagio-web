<?php
	include("conexao.php");

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
	}

	if($_GET['loadnews'] == "yes"){
		$retorno = "<h3 class='tituloInicio'>Últimas notícias</h3>";
		$resultNews = $mysqli->query("SELECT ID, titulo, descricao, img, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data, autor FROM noticia ORDER BY data DESC LIMIT 20");
		while($linhaNews = $resultNews->fetch_assoc()) {
			$retorno .= "<a class='linkNoticia' href='visualizar.html?id=".$linhaNews['ID']."'>";
			$retorno .= "<div class='noticia' style='background: url(".$linhaNews['img']."); background-size: cover; background-position: center;'>";
			$retorno .= "<span class='dataNoticia'><i class='far fa-calendar-alt'></i> ".$linhaNews['data']."</span>";
			$retorno .= "<div class='infoNoticia'>";
			$retorno .= "<span style='font-weight: bold; margin-bottom: 1%;'>".$linhaNews['titulo']."</span>";
			$retorno .= "<span class='descricao-curta'>".$linhaNews['descricao']."</span>";
			$retorno .= "<span style='color: #e85b25;'>".$linhaNews['autor']."</span>";
			$retorno .= "</div>";
			$retorno .= "</div>";
			$retorno .= "</a>";
		}

		echo $retorno;
	}

	if($_GET['detailnews'] != ""){
		$resultNews = $mysqli->query("SELECT ID, titulo, descricao, img, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data, autor FROM noticia ORDER BY data DESC LIMIT 20");
		
		$retorno = "";

		echo $retorno;
	}	
?>