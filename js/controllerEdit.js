    function nomeUsuario(){
        var usuario = document.getElementById("usuario");
        var sair = document.getElementById("sairBtn");
        var crud = document.getElementById("botoesNoticia");
        var autor = document.getElementsByClassName("autor");

        if(sessionStorage.getItem("UsuarioLogado") != null){
            usuario.innerHTML = sessionStorage.getItem("UsuarioLogado");
            sair.style.display = "block";
            usuario.href = "#";
        }
    }

    function deslogar(){
        sessionStorage.removeItem("UsuarioLogado");
        location.href = "/";
    }

    var inputs = document.getElementsByClassName("inp-post");
    var textareas = document.getElementsByClassName("TApost");
    var hidden = document.getElementById("idnews");
    if(sessionStorage.getItem("NoticiaEditada") != null){
        var NoticiaEditada = JSON.parse(sessionStorage.getItem("NoticiaEditada"));
        inputs[0].value = NoticiaEditada.Autor;
        inputs[1].value = NoticiaEditada.Titulo;
        textareas[0].value = NoticiaEditada.Descricao;
        hidden.value = NoticiaEditada.ID;
    }