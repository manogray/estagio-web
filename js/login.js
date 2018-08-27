function switchLogin(opcao){
	
	var tabLogar = document.getElementById("entrar");
	var tabRegistrar = document.getElementById("registrar");
	var email = document.getElementById("email");
	var confirmar = document.getElementById("confirmar");
	var registrar = document.getElementById("registrarBtn");
	var logar = document.getElementById("entrarBtn");
	var modo = document.getElementById("modo");

	if(opcao == 1){
		tabLogar.style.color = "#f5f5f5";
		tabLogar.style.background = "#0b336f";
		tabRegistrar.style.color = "#333";
		tabRegistrar.style.background = "#ccc";
		
		email.style.display = "none";
		confirmar.style.display = "none";
		registrar.style.display = "none";
		logar.style.display = "block";
		modo.value = "entrar";
	}else {
		tabLogar.style.color = "#333";
		tabLogar.style.background = "#ccc";
		tabRegistrar.style.color = "#f5f5f5";
		tabRegistrar.style.background = "#0b336f";
		
		email.style.display = "block";
		confirmar.style.display = "block";
		registrar.style.display = "block";
		logar.style.display = "none";
		modo.value = "registrar";
	}
}

if(sessionStorage.getItem("UsuarioLogado") != null){
	location.href = "/";
}