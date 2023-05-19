$(document).ready(function () {
    $("#form-editar-indicador").find("input").on("change", function () {
        if ($("#edit-valor").val() !== "" && $("#edit-fecha").val() !== "") {
            $("#btn-editar-form").prop("disabled", false);
        } else {
            $("#btn-editar-form").prop("disabled", true);
        }
    });
});

function colorRegistroAEditar(registro, modo) {
    if (modo === "normal") {
        registro.css("background-color", "white");
        registro.css("transition", "background-color 0.5s ease");
    } else if (modo === "modificado") {
        registro.css("background-color", "orange");
    }
}

function editarUF(id, indice, fecha, valor) {
    $("#edit-id").val(id);
    $("#edit-fecha").val(fecha);
    $("#edit-valor").val(valor);

    if ($("#btn-editar-form").prop("disabled", false)) {
        $("#close-modal-editar").attr("data-indice", indice);
        let registro = $(`#lista-uf-registro-${indice}`);
        colorRegistroAEditar(registro, "modificado");
    }
}

$("#modal-editar-uf").on('hidden.bs.modal', function () {
    let indice = $("#close-modal-editar").attr("data-indice");
    let registro = $(`#lista-uf-registro-${indice}`);
    colorRegistroAEditar(registro, "normal");
});

$("#form-editar-indicador").on("submit", function (event) {
    event.preventDefault();
    let indice = $("#close-modal-editar").attr("data-indice");
    let registro = $(`#lista-uf-registro-${indice}`);

    let formData = new FormData(document.getElementById("form-editar-indicador"));
    $.ajax({
            url: baseUrl + '/editar-indicador',
            type: 'POST',
            dataType: 'json',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (result) {
            $("#close-modal-editar").click();
            msnResult(result);
            reloadTable();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            colorRegistroAEditar(registro, "normal");
            alert("Falló algo en el ajax");
        });
});