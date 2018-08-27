function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
          
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
          
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
      
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
}   

    if(sessionStorage.getItem("NoticiaEditada") != null){
        sessionStorage.removeItem("NoticiaEditada");
    }
    
    //EXIBE ULTIMAS 20 NOTICIAS
    var contentNews = document.getElementsByClassName("contentNoticias");

    if(contentNews != null){
        var xmlreq = CriaRequest();
        var UltimasNoticias;
        var contador = 0;
        var html = "<h3 class='tituloInicio'>Últimas notícias</h3>";
            
        xmlreq.open("GET","php/noticias.php?loadnews=yes",true);
            
        xmlreq.onreadystatechange = function(){
                  
            if (xmlreq.readyState == 4) {
                      
                if (xmlreq.status == 200) {

                    UltimasNoticias = JSON.parse(xmlreq.responseText);
                    while(contador < UltimasNoticias.length){
                        html += "<a class='linkNoticia' href='visualizar.html?id="+UltimasNoticias[contador].ID+"'>";
                        html += "<div class='noticia' style='background: url("+UltimasNoticias[contador].Imagem+"); background-size: cover; background-position: center;'>";
                        html += "<span class='dataNoticia'><i class='far fa-calendar-alt'></i> "+UltimasNoticias[contador].Data+"</span>";
                        html += "<div class='infoNoticia'>";
                        html += "<span style='font-weight: bold; margin-bottom: 1%;'>"+UltimasNoticias[contador].Titulo+"</span>";
                        html += "<span class='descricao-curta'>"+UltimasNoticias[contador].Descricao+"</span>";
                        html += "<span style='color: #e85b25;'>"+UltimasNoticias[contador].Autor+"</span>";
                        html += "</div>";
                        html += "</div>";
                        html += "</a>";

                        contador = contador + 1;
                    }
                    contentNews[0].innerHTML = html;

                }else{
                    contentNews[0].innerHTML = "Erro: " + xmlreq.statusText;
                }
            }
        };
        xmlreq.send(null);
    }

    function deslogar(){
        sessionStorage.removeItem("UsuarioLogado");
        location.href = "/";
    }

    function nomeUsuario(){
        var usuario = document.getElementById("usuario");
        var sair = document.getElementById("sairBtn");
        var crud = document.getElementById("botoesNoticia");
        var autor = document.getElementsByClassName("autor");

        if(sessionStorage.getItem("UsuarioLogado") != null){
            usuario.innerHTML = sessionStorage.getItem("UsuarioLogado");
            sair.style.display = "block";
            usuario.href = "#";

            if(crud != null && autor[0].innerHTML == sessionStorage.getItem("UsuarioLogado")){
                crud.innerHTML = "<a href='editar.html?id="+vectorGET.valor+"' title='Editar Notícia' style='margin-right: 20px;'><i class='far fa-edit'></i></a><a title='Deletar Notícia' style='margin-right: 20px;' href='#'><i style='color: #ff0000;' class='far fa-trash-alt'></i></a>";
            }
        }
    }