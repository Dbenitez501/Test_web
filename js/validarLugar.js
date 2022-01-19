function validar()
{
    var nombre, cap_max, ubicacion, descripcion;

    nombre = document.getElementById("nombre").value;
    cap_max = document.getElementById("cap_max").value;
    ubicacion = document.getElementById("ubicacion").value;
    descripcion = document.getElementById("desc").value;

    if(nombre === "" || cap_max === "" || ubicacion === "" || descripcion === "") {
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(nombre.length > 200) {
        alert("El nombre de lugar es muy largo");
        return false;
    }
    else if(isNaN(cap_max)) {
        alert("Capacidad máxima inválida");
        return false;
    }
    else if(ubicacion.length > 100) {
        alert("La ubicación es muy larga");
        return false;
    }
    else if(descripcion.length > 200) {
        alert("La descripción es muy larga");
        return false;
    }
}