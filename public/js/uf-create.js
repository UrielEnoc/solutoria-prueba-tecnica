$(document).ready(function () {
    colocarAsteriscosRequired("form-agregar-indicador");

    $("#form-agregar-indicador").on("submit", function (event) {
        event.preventDefault();
        let formData = new FormData(document.getElementById("form-agregar-indicador"));
        $.ajax({
                url: baseUrl + '/agregar-indicador',
                type: 'POST',
                dataType: 'json',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function (result) {
                msnResult(result, "limpiarForm()");
                reloadTable();
                mensajeCargarLista("nuevo");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("Falló algo en el ajax");
            })
    });

    $("#form-agregar-indicador").find("input").on("change", function () {
        if ($("#add-valor").val() !== "" && $("#add-fecha").val() !== "") {
            $("#btn-agregar-form").prop("disabled", false);
        } else {
            $("#btn-agregar-form").prop("disabled", true);
        }
    });
});

function limpiarForm() {
    $("#add-valor").val("");
    $("#add-fecha").val("");
    $("#btn-agregar-form").prop("disabled", true);
}