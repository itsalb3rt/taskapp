// JavaScript Document

/**
 * modal crear usuario
 **/
    $(document).on('click', '.crear_usuario', function (event) {
        event.preventDefault();
        $('.modal_crear_usuario').iziModal('open');
    });

    $(".modal_crear_usuario").iziModal(modal_data('Crear usuario','Todos los campos obligatorios están resaltados en el formulario','#03A9F4'));

/**
 *
 * Se creo esta funcion para solo declarar 1 vez un objeto tipo izimodal
 * ya que de no ser asi tendria que crearse varias instancias de este objeto por cada modal
 * con esto se tiene un estandar de modal, osea todos los modales seran iguales
 *
 * Retorna los datos del modal al objeto izimodal
 *
 *
 **/
function modal_data(titulo, subtitulo,color_encabezado = '#2196F3',tamano = 600) {
    var modal_data = {
        title: titulo,
        subtitle: subtitulo,
        headerColor: color_encabezado,
        background: null,
        theme: '', // light
        icon: null,
        iconText: null,
        iconColor: '',
        rtl: false,
        width: tamano,
        top: 100, //Posicion del top
        bottom: null,
        borderBottom: true,
        padding: 10,
        radius: 5,
        zindex: 500,
        iframe: false,
        iframeHeight: 400,
        iframeURL: null,
        focusInput: true,
        group: '',
        loop: false,
        arrowKeys: true,
        navigateCaption: true,
        navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
        history: false,
        restoreDefaultContent: false,
        autoOpen: 0, // Boolean, Number
        bodyOverflow: false,
        fullscreen: false,
        openFullscreen: false,
        closeOnEscape: true,
        closeButton: true,
        appendTo: 'body', // or false
        appendToOverlay: 'body', // or false
        overlay: true,
        overlayClose: true,
        overlayColor: 'rgba(0, 0, 0, 0.5)',
        timeout: false,
        timeoutProgressbar: false,
        pauseOnHover: false,
        timeoutProgressbarColor: 'rgba(255,255,255,0.5)',
        transitionIn: 'comingIn',
        transitionOut: 'comingOut',
        transitionInOverlay: 'toggle',
        transitionOutOverlay: 'fadeOut',
        onFullscreen: function () {},
        onResize: function () {},
        onOpening: function () {},
        onOpened: function () {},
        onClosing: function () {},
        onClosed: function () {},
        afterRender: function () {}
    };
    return modal_data; 
}

