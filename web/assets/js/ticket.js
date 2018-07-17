/**
 * Maneja las funciones relacionadas a los tickets
 *
 *
 */

function cambiar_estado_ticket(ticket_id,estado){
    var nuevo_estadp = estado;
    $.ajax({
        url:Routing.generate('cambiar_estado',{id:ticket_id}),
        type:'PUT',
        data: JSON.stringify({'estado':nuevo_estadp}) ,
        success:function(response){
            console.log(response);
            $('.boton_iniciar_tarea').prop('disabled','disabled');
            desplegar_notificacion('Tarea iniciada');
        },
        error:function(err){
            console.log(err.responseText);

        }
    });
}

function agregar_nota(id,usuario,comentario){
    //Algunas variables
    var id_ticket = id;
    var id_usuario_nota = usuario;
    var nota = comentario;

    $.ajax({
        url:Routing.generate('guardar_nota'),
        type:'POST',
        data:JSON.stringify({usuarioId:id_usuario_nota,comentario:nota,ticket:id_ticket}),
        success:function(response){
            desplegar_notificacion('Nota agregada');
            $('.modal_agregar_nota').iziModal('close');
            console.log(response);
        },
        error:function(err){
            console.log(err.responseText);
        }
    });
}