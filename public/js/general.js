function msnResult(result, funcion = null) {
    $.alert({
        icon: eval(result.icono),
        title: result.titulo,
        content: result.mensaje,
        type: result.color,
        theme: 'dark',
        typeAnimated: true,
        scrollToPreviousElement: false,
        columnClass: 'medium',
        buttons: {
            cerrar: {
                text: 'Cerrar',
                btnClass: 'btn-blue',
                action: function () {
                    if (funcion !== null) eval(funcion);
                }
            },
        }
    });
}

function colocarAsteriscosRequired(form) {
    let campos = $(`#${form}`).find("input").toArray();

    campos.forEach(campo => {
        if ($(campo).prop("required")) {
            $(campo).siblings("label").after(`<span class="text-danger ms-1">*</span>`);
        }
    });
}