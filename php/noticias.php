<?php
	include("conexao.php");

	if($_GET['loadnews'] == "yes"){
		$retorno = "<h3 class='tituloInicio'>Últimas notícias</h3>";
		$resultNews = $mysqli->query("SELECT * FROM noticia ORDER BY data DESC LIMIT 20");
		while($linhaNews = $resultNews->fetch_assoc()) {
			$retorno .= "<a class='linkNoticia' href='visualizar.html'>";
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
?>