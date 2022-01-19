function validar() {
    var titulo, desc, expositor, fecha, hora, plataforma, codigo_plat, codigo_as, capacidad_max, expresionHora, expresionFecha;

    titulo = document.getElementById("titulo").value;
    desc = document.getElementById("descripcion").value;
    expositor = document.getElementById("expositor").value;
    fecha = document.getElementById("fecha").value;
    hora = document.getElementById("hora").value;
    plataforma = document.getElementById("plataforma").value;
    codigo_plat = document.getElementById("codigo_plat").value;
    codigo_as = document.getElementById("codigo_as").value;
    capacidad_max = document.getElementById("cap_max").value;

    expresionHora = /\d+\d+:+\d+\d/;
    expresionFecha = /\d+\d+\d+\d+\-+\d+\d+\-+\d+\d/;

    if (titulo === "" || desc === "" || expositor === "" || fecha === "" || hora === "" || plataforma === "" || codigo_plat === "" || codigo_as === "" || capacidad_max === "") {
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if (titulo.length > 255) {
        alert("El título es muy largo");
        return false;
    }
    else if (desc.length > 300) {
        alert("La descricpión es muy larga");
        return false;
    }
    else if (expositor.length > 200) {
        alert("Nombre de expositor muy largo");
        return false;
    }
    else if (!expresionHora.test(hora)) {
        alert("Formato de hora no válida, debe ser de 24 horas (00:00)");
        return false;
    }
    else if (!expresionFecha.test(fecha)) {
        alert("Formato de fecha no válida, debe ser yyyy/mm/dd");
        return false;
    }
    else if (plataforma.length > 50) {
        alert("Nombre de plataforma muy largo, mayor a 50 caracteres");
        return false;
    }
    else if (codigo_plat.length > 25) {
        alert("Código de plataforma muy largo, mayor a 25 caracteres");
        return false;
    }
    else if (codigo_as.length > 25) {
        alert("Código de asistencia muy largo, mayor a 25 caracteres");
        return false;
    }
    else if (isNaN(capacidad_max)) {
        alert("Capacidad máxima no es un número");
    }
}