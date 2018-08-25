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
    
    var contentNoticias = document.getElementById("contentNoticias");
    var xmlreq = CriaRequest();
    
    xmlreq.open("GET","php/noticias.php?loadnews",true);
    
    xmlreq.onreadystatechange = function(){
          
         if (xmlreq.readyState == 4) {
              
             if (xmlreq.status == 200) {
                 contentNoticias.innerHTML = xmlreq.responseText;
             }else{
                 contentNoticias.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);