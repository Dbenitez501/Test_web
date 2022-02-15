function validar() 
{
    var codigo, comentario;

    codigo = document.getElementById("codigo").value;
    comentario = document.getElementById("comentario").value;

    if(codigo === "" || comentario === "") {
      alert("Todos los campos son necesarios");
      return false;
    }
    else if(comentario.length > 300) {
      alert("El comentario es muy largo (Máximo 300 caracteres)");
      return false;
    }
}