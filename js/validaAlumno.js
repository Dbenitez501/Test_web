function validar() 
{
    var nombre, matricula, carrera, email, telefono, sexo, pais, username, contra, expresion_mail, expresion_nombre;
    var s = false;
    
    nombre = document.getElementById("nombre").value;
    matricula = document.getElementById("mat").value;
    carrera = document.getElementById("carreras").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    sexo = document.formAlumno.sexo;
    pais = document.getElementById("paises").value;
    username = document.getElementById("username").value;
    contra = document.getElementById("contra").value;

    //Formato para los correos y el nombre completo
    expresion_mail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
    expresion_nombre= /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;

    if(nombre === "" || matricula === "" || carrera === "" || email === "" || telefono === "" || sexo === "" || pais === "" || username === "" || contra === "") {
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
    else if(matricula.length < 7) {
        alert("La matricula es muy corta (Debe contener 7 dígitos)");
        return false;
    }
    else if(matricula.length > 7) {
        alert("La matricula es muy largo (Debe contener 7 dígitos)");
        return false;
    }
    else if(isNaN(matricula)) {
        alert("La matricula debe contener solo dígitos enteros (Debe contener 7 dígitos)");
        return false;
    }
    else if(email.length > 200) {
        alert("El email es muy largo (Máximo 200 caracteres)");
        return false;
    }
    else if(!expresion_mail.test(email)) {
        alert("El email no es válido");
        return false;
    }
    else if(telefono.length > 10) {
        alert("El teléfono debe contener 10 dígitos");
        return false;
    }
    else if(telefono.length < 10) {
        alert("El teléfono debe contener 10 dígitos");
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
        alert("El teléfono contiene caracteres inválidos. Debe de ser numérico y contener 10 dígitos");
        return false;
    }
    else if(pais === "Elegir") {
        alert("Seleccione su país de origen");
        return false;
    }
    else if(carrera === "Elegir") {
        alert("Seleccione su carrera");
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