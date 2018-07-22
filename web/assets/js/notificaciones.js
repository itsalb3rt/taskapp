
/**
 * mostrar a bandeja de las notificaciones
 **/
$(document).on('click', '.menu_notificaciones', function () {
	$('.bandeja_notificaciones').slideToggle(100);
    $('.bandeja_notificaciones .cuerpo_bandeja_notificaciones .lista_notificaciones').empty().append('<li class="ninguna_notificacion"><div><i class="glyphicon glyphicon-magnet"></i>&Tab;<br>Nada por aqui </div></li>');
});

/**
 * Oculta la bandeja de notificaciones
 **/
$(document).on('click', '.starter-template', function () {
	$('.bandeja_notificaciones').hide(100);
});


function capitalizeFirstLetter(string) {
	var tocapitalize = string.toLowerCase();
    return tocapitalize.charAt(0).toUpperCase() + tocapitalize.slice(1);
}
