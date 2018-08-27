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

    if(sessionStorage.getItem("NoticiaEditada") != null){
        sessionStorage.removeItem("NoticiaEditada");
    }

    function deslogar(){
        sessionStorage.removeItem("UsuarioLogado");
        location.href = "/";
    }

    var inputs = document.getElementsByClassName("inp-post");
    if(sessionStorage.getItem("UsuarioLogado") != null){
        inputs[0].value = sessionStorage.getItem("UsuarioLogado");
    }