$(document).ready(function () {
    /* Funciones de pestaña */
    mensajeCargarLista("cargar");

    $("#username").on("keydown keyup change", function () {
        if ($(this).val() === "") {
            $("#btn-traer-indicadores").prop("disabled", true);
        } else {
            $("#btn-traer-indicadores").prop("disabled", false);
        }
    });

    /* Funciones de carga de tabla */
    $("#form-carga-inicial-indicadores").on("submit", function (event) {
        event.preventDefault();
        let formData = new FormData(document.getElementById("form-carga-inicial-indicadores"));

        $.ajax({
                url: baseUrl + '/traer-indicadores',
                type: 'POST',
                dataType: 'json',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function (result) {
                if (result.httpCode == 200) {
                    llenarTablaUF(result.response);
                    cargarGrafico(result.response);
                } else {
                    mensajeCargarLista("error", result.mensaje);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("Falló algo en el ajax");
            })
    });
});

function mensajeCargarLista(tipo = "cargar", mensaje = null) {
    let divMensaje = $("#mensaje-cargar-lista");
    if (tipo === "cargar") {
        divMensaje.html(`
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Usuario sugerido: </strong> <small>urielolivaresby5s9_4mm@indeedemail.com</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
        `);
    } else if (tipo === "nuevo") {
        if($("#msn-nuevos-registros").length === 0){
            $("#div-recargar-indicadores").before(`
                        <div id="msn-nuevos-registros" class="alert alert-success alert-dismissible fade show" role="alert">
                            ¡Ha agregado registros y la lista se ha actualizado!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
            `);
        }
    } else if (tipo === "error") {
        divMensaje.html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${mensaje} Pruebe con: <small>urielolivaresby5s9_4mm@indeedemail.com</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
        `);
    }
}


function quitarCredencialesDeCargaDeDatos() {
    $("#form-carga-inicial-indicadores").remove();
    $("#msnInitFormAdd").remove();
    $("#form-add-container").removeClass("d-none");
    $("#form-footer-add-container").removeClass("d-none");
    $("#chart-container").removeClass("d-none");
    setTimeout(function(){
        $("#dateToControl").change();
    }, 1000);
    
    if ($("#div-recargar-indicadores").length === 0) {
        $("#card-body-listar-uf").prepend(`
            <div id="div-recargar-indicadores" class="row g-3 mb-3 px-2">
                <button type="button" onclick="reloadTable(true)" class="btn btn-info btn-block">Recargar lista</button>
            </div>
        `);
    }
}

function llenarTablaUF(datos) {
    quitarCredencialesDeCargaDeDatos();

    if ($.fn.DataTable.isDataTable("#tableUF")) {
        $("#tableUF").DataTable().clear().destroy();
    }

    $("#tableUF-container").removeClass("d-none");
    let html = "";

    for (let i = 0; i < datos.length; i++) {
        let indice = i + 1;
        let registro = datos[i];
        html += `
            <tr id="lista-uf-registro-${indice}">
                <td>` + indice + `</td>
                <td>` + registro.codigo + `</td>
                <td>` + registro.nombre + `</td>
                <td>` + registro.unidad + `</td>
                <td class="td-valor">` + registro.valor + `</td>
                <td class="td-fecha">` + registro.fecha + `</td>
                <td class="td-fecha">` + registro.origen + `</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Opciones
                        </button>
                        <ul class="dropdown-menu dropdown-menu">
                            <li><button onclick="editarUF(${registro.id}, ${indice}, '${registro.fecha}', '${registro.valor}')" type="button" data-bs-toggle="modal" data-bs-target="#modal-editar-uf" class="dropdown-item btn btn-link">Modificar</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button onclick="eliminarUF(${registro.id}, ${indice}, '${registro.fecha}')" button type="button" class="text-danger dropdown-item btn btn-link">Eliminar</button></li>
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    }

    $("#tableUF-body").html(html);
    initTable();
}

function reloadTable(btn = false) {
    if(btn) $("#msn-nuevos-registros").remove();

    $.ajax({
            type: "GET",
            url: baseUrl + '/listar-indicadores',
            dataType: 'json',
            async: true,
        })
        .done(function (result) {
            llenarTablaUF(result.response);
            cargarGrafico(result.response);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert("Falla en volver a llenar tabla de ufs");
        });
}