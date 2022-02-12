function validar()
{
    var nombre, numero_emp, email, telefono, sexo, username, contra, expresion_mail, expresion_nombre;
    var s = false;
    
    nombre = document.getElementById("nombre").value;
    numero_emp = document.getElementById("numero_emp").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    sexo = document.formDocente.sexo;
    pais = document.getElementById("paises").value;
    username = document.getElementById("username").value;
    contra = document.getElementById("contra").value;

    //Formato para los correos
    expresion_mail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
    expresion_nombre= /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;

    if(nombre === "" || numero_emp === "" || email === "" || telefono === "" || sexo === "" || pais==="" || username === "" || contra === "" ) {
        alert("Todos los campos son obligatorios");
        return false;
    } 
    else if(nombre.length > 250) {
        alert("El nombre es muy largo");
        return false;
    }
    else if(!expresion_nombre.test(nombre)) {
        alert("Formato de Nombre completo incorrecto, compruebe que no contenga números ni caracteres especiales.");
        return false;
    }
    else if(username.length > 50) {
        alert("El Usuario es muy largo (Máximo 50 caracteres)");
        return false;
    }
    else if(username.length < 7) {
        alert("El Usuario es muy corto (Mínimo 7 caracteres)");
        return false;
    }
    else if(numero_emp.length > 7) {
        alert("El número de empleado es muy largo (Máximo 7 dígitos)");
        return false;
    }
    else if(isNaN(numero_emp)) {
        alert("El número de empleado debe contener solo dígitos enteros (Máximo 7 dígitos)");
        return false;
    }
    else if(email.length > 100) {
        alert("El email es muy largo (Máximo 100 caracteres)");
        return false;
    }
    else if(!expresion_mail.test(email)) {
        alert("El email no es válido");
        return false;
    }
    else if(telefono.length > 10) {
        alert("El teléfono solo es de 10 dígitos");
        return false;
    }
    else if(contra.length > 40) {
        alert("La contraseña es demasiado larga (Máximo 40 caracteres)");
        return false;
    }
    else if(contra.length < 7) {
        alert("La contraseña es demasiado corta (Mínimo 7 caracteres)");
        return false;
    }
    else if(isNaN(telefono)) {
        alert("El teléfono contiene caracteres inválidos");
        return false;
    }
    else if(pais === "Elegir") {
        alert("Seleccione su país de origen");
        return false;
    }

    for(var i=0; i<sexo.length;i++) {
        if(sexo[i].checked) {
            s=true;
            break;
        }
    }
    if(!s) {
        alert("Debe seleccionar el género");
        return false;
    }
}