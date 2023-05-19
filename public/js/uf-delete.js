function colorRegistroAEliminar(registro, modo) {
    if (modo === "normal") {
        registro.css("background-color", "white");
        registro.css("color", "black");
    } else if (modo === "modificado") {
        registro.css("background-color", "red");
        registro.css("color", "white");
    }
}

function quitarRegistro(indice) {
    let tiempo = 500;
    let registro = $(`#lista-uf-registro-${indice}`);
    registro.fadeOut(tiempo);
    setTimeout(function () {
        reloadTable();
    }, tiempo);
}

function eliminarUF(id, indice, fecha) {
    let registro = $(`#lista-uf-registro-${indice}`);
    colorRegistroAEliminar(registro, "modificado");

    $.confirm({
        title: 'Eliminación de UF',
        content: `¿Está seguro que desea eliminar el registro de UF ${indice}, con fecha ${fecha}?`,
        theme: 'dark',
        buttons: {
            no: {
                text: 'Mantener',
                btnClass: 'btn-green',
                action: function () {
                    colorRegistroAEliminar(registro, "normal");
                }
            },
            si: {
                text: 'Eliminar',
                btnClass: 'btn-red',
                action: function () {
                    $.ajax({
                            type: "POST",
                            url: baseUrl + '/eliminar-indicador',
                            dataType: 'json',
                            data: {
                                'id': id,
                            }
                        })
                        .done(function (result) {
                            quitarRegistro(indice);
                            msnResult(result);
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            colorRegistroAEliminar(registro, "normal");
                            alert("Falla en eliminar indicador");
                        });
                }
            },
        }
    });
}