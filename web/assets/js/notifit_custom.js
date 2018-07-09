
/**
* Este archivo se creo con el fin de no tener esta funcion en todos los archivos js del proyecto
*
* Muestra una notificacion con la libreria notifIt
*
*@mensaje [El mensaje que se desa mostrar en pantalla]
@tipo [Es el tipo de notificacion a mostrar por defecto es 'success']
**/
function desplegar_notificacion(mensaje,tipo = 'success',posicion = 'right',opacidad = 1){
	notif({
			msg: mensaje,
			type: tipo,
			position: posicion,
			opacity: opacidad
			});
}