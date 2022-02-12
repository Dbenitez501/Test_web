function validar() 
{
    var nombre, matricula, carrera, email, telefono, sexo, username, contra, expresion_mail;
    var s = false;
    
    nombre = document.getElementById("nombre").value;
    matricula = document.getElementById("mat").value;
    carrera = document.getElementById("carrera").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    sexo = document.formAlumno.sexo;
    pais = document.getElementById("paises").value;
    username = document.getElementById("username").value;
    contra = document.getElementById("contra").value;

    //Formato para los correos
    expresion_mail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if(nombre === "" || matricula === "" || carrera === "" || email === "" || username === "" || contra === "") {
        alert("Todos los campos son obligatorios, excepto el Teléfono");
        return false;
    } 
    else if(nombre.length > 250) {
        alert("El nombre es muy largo");
        return false;
    }
    else if(matricula.length > 7) {
        alert("La matrícula es muy larga");
        return false;
    }
    else if(username.length > 100) {
        alert("El username es muy largo");
        return false;
    }
    else if(email.length > 100) {
        alert("El email es muy largo");
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
        alert("La contraseña es demasiado larga");
        return false;
    }
    else if(isNaN(telefono)) {
        alert("El teléfono contiene caracteres inválidos");
        return false;
    }

    for(var i=0; i<sexo.length;i++) {
        if(sexo[i].checked) {
            s=true;
            break;
        }
    }
    if(!s) {
        alert("Debe seleccionar sexo");
        return false;
    }
}

//Seccion de Cuenta
function validar2() 
{
    var telefono, contra, contra2;
    
    telefono = document.getElementById("telefono").value;
    contra = document.getElementById("contra").value;
    contra2 = document.getElementById("contraconf").value;

    if(telefono === "" || contra === "" || contra2 === "") {
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(telefono.length > 10) {
        alert("El teléfono solo es de 10 dígitos");
        return false;
    }
    else if(contra.length > 40) {
        alert("La contraseña es demasiado larga");
        return false;
    }
    else if(isNaN(telefono)) {
        alert("El teléfono contiene caracteres inválidos");
        return false;
    }else if (contra!==contra2) {
        alert("Las contraseñas no son iguales");
        return false;
    }
}