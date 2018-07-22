/**
 * Muestra el contenido que coincida con el parametro de entrada
 * buscando dentro de un contenedor, por ejemplo una tabla de datos
 *
 **/
function filtrar_contenido(parametro,caja_filtro){
    var value = parametro.toLowerCase();
    $(caja_filtro).filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}