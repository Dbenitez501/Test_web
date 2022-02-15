function validar() {
    var titulo, desc, expositor, fecha, hora, lugar, codigo_as, expresionHora, expresionFecha, imagen;

    titulo = document.getElementById("titulo").value;
    desc = document.getElementById("descripcion").value;
    expositor = document.getElementById("expositor").value;
    fecha = document.getElementById("fecha").value;
    hora = document.getElementById("hora").value;
    lugar = document.getElementById("lugar").value;
    codigo_as = document.getElementById("codigo_as").value;
    imagen = document.getElementById("image").value;

    expresionHora = /\d+\d+:+\d+\d/;
    expresionFecha = /\d+\d+\d+\d+\-+\d+\d+\-+\d+\d/;

    if (titulo === "" || desc === "" || expositor === "" || fecha === "" || hora === "" || lugar === "escoge" || codigo_as === "" || imagen === "") {
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if (lugar === "escoge") {
        alert("Debe escoger un lugar");
        return false;
    }
    else if (titulo.length > 255) {
        alert("El título es muy largo");
        return false;
    }
    else if (desc.length > 500) {
        alert("La descricpión es muy larga (Máximo 500 caracteres)");
        return false;
    }
    else if (expositor.length > 200) {
        alert("Nombre de expositor muy largo (Máximo 200 caracteres)");
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
    else if (codigo_as.length > 25) {
        alert("Código de asistencia muy largo, mayor a 25 caracteres");
        return false;
    }
}