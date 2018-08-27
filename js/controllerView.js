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

function PegaGET(){
    var urlAtual = window.location.href.toString();
    var vectorGET = new Object;
    if(urlAtual.indexOf("?") > -1){
        var urlAtualCortada = urlAtual.split("?");
        var pedacosGET = urlAtualCortada[1].split("=",2);

        vectorGET.nome = pedacosGET[0];
        vectorGET.valor = pedacosGET[1];
    }

    return vectorGET;
}
    
    
    var vectorGET = PegaGET();

    //EXIBE DETALHES DE UMA NOTICIA
    var contentDetailNews = document.getElementsByClassName("contentDetalhes");
    var NoticiaExibida;

    if(contentDetailNews != null){
        var titleDetailNews =  document.getElementsByTagName("title");
        var xmlreq = CriaRequest();
        var html;

        if(vectorGET.nome == "id"){
            xmlreq.open("GET","php/noticias.php?detailnews="+vectorGET.valor,true);

            xmlreq.onreadystatechange = function(){
                  
            if(xmlreq.readyState == 4) {
                      
                if(xmlreq.status == 200) {

                    NoticiaExibida = JSON.parse(xmlreq.responseText);
                    html = "<div class='fotoNoticia borrar' style='background: url("+NoticiaExibida.Imagem+"); background-position: center; background-size: contain;' id='fotoNews'></div>";
                    html += "<div class='fotoNoticia' style=' position: absolute; background: url("+NoticiaExibida.Imagem+") rgba(0,0,0,0.6); background-size: contain; background-position: center; background-repeat: no-repeat;'></div>"
                    html += "<div class='contentDetalhesNoticia'>";
                    html += "<h3 class='tituloDetalhes'>"+NoticiaExibida.Titulo+"</h3>";
                    html += "<div class='topbarDetalhes'>";
                    html += "<span class='autor'>"+NoticiaExibida.Autor+"</span>";
                    html += "<span class='data'><i class='far fa-calendar-alt'></i> "+NoticiaExibida.Data+"</span>";
                    html += "</div>";
                    html += "<div class='botoesNews' id='botoesNoticia'></div>";
                    html += "<span class='descricao-completa'>"+NoticiaExibida.Descricao+"</span>";
                    html += "</div>";

                    titleDetailNews[0].innerHTML = NoticiaExibida.Titulo+" - ComicsNews";
                    contentDetailNews[0].innerHTML = html;

                    sessionStorage.setItem("NoticiaEditada",JSON.stringify(NoticiaExibida));

                }else{
                    contentDetailNews[0].innerHTML = "Erro: " + xmlreq.statusText;
                }
            }
        };
        xmlreq.send(null);
        }


    }

    function deslogar(){
        sessionStorage.removeItem("UsuarioLogado");
        location.href = "/";
    }

    function deletarNoticia(id){

        if(confirm("Isso irá apagar a notícia. Você tem certeza?")){
            var xmlreq = CriaRequest();

            xmlreq.open("GET","php/noticias.php?deletenews="+id,true);
            
            xmlreq.onreadystatechange = function(){
                if(xmlreq.readyState == 4){
                    if(xmlreq.status == 200){
                        document.write(xmlreq.responseText);
                    }else {
                        alert("Erro: "+xmlreq.statusText);
                    }
                }
            };
            xmlreq.send(null);
        }
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
                crud.innerHTML = "<a href='editar.html' title='Editar Notícia' style='margin-right: 20px;'><i class='far fa-edit'></i></a><a title='Deletar Notícia' style='margin-right: 20px;' onclick='deletarNoticia("+vectorGET.valor+")' ><i style='color: #ff0000;' class='far fa-trash-alt'></i></a>";
            }
        }
    }