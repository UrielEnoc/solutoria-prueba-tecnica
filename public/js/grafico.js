var fechas = [];
var valores = [];
var datos = [];
var lineChart = undefined;

$(document).ready(function () {
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
    });
});


function cargarDateInicialGrafico(fecha) {
    $("#dateFromControl").val(fecha);
    $("#dateFromControl").datepicker("option", "minDate", new Date(fecha));
    $("#dateToControl").datepicker("option", "minDate", new Date(fecha));
}

function cargarDateFinalGrafico(fecha) {
    $("#dateToControl").val(fecha);
    $("#dateFromControl").datepicker("option", "maxDate", new Date(fecha));
    $("#dateToControl").datepicker("option", "maxDate", new Date(fecha));
}

function datosFiltradosGrafico() {
    let fechaInicial = moment(new Date($("#dateFromControl").val())).format("YYYY-MM-DD");
    let fechaFinal = moment(new Date($("#dateToControl").val())).format("YYYY-MM-DD");
    let nuevasFechas = [];
    let nuevosValores = [];

    for (let i = 0; i < fechas.length; i++) {
        let fecha = moment(fechas[i], "YYYY-MM-DD");
        if (fecha.isSameOrAfter(fechaInicial) && fecha.isSameOrBefore(fechaFinal)) {
            console.clear();
            console.log("entra: ", i);
            nuevasFechas.push(fechas[i]);
            nuevosValores.push(valores[i]);
        }
    }
    return {
        "nuevasFechas": nuevasFechas,
        "nuevosValores": nuevosValores,
    }
}

function cargarGrafico(data) {
    if (fechas.length > 0) {
        fechas = [];
        valores = [];
    }

    data = data.reverse();
    for (let i = 0; i < data.length; i++) {
        let fecha = data[i].fecha;
        fechas.push(fecha);
        if (i === 0) cargarDateInicialGrafico(fecha);
        if (i === (data.length - 1)) cargarDateFinalGrafico(fecha);
    }
    data.forEach(element => {
        valores.push(element.valor);
    });


    $(".datepicker").on("change", function () {
        updateChart();
    });

    function updateChart() {
        // Eliminar el gráfico existente si existe
        if (typeof lineChart !== 'undefined') {
            lineChart.destroy();
        }

        // Datos originales del gráfico
        let originalData = {
            labels: fechas,
            datasets: [{
                label: "Valores de UF por fechas",
                data: valores,
                borderColor: "blue",
                backgroundColor: "transparent"
            }]
        };

        // Configuración del gráfico
        let options = {
            responsive: true,
            maintainAspectRatio: true
        };

        // Crear el gráfico de línea inicial
        let ctx = document.getElementById("lineChart").getContext("2d");
        lineChart = new Chart(ctx, {
            type: "line",
            data: originalData,
            options: options
        });

        let fromDate = $("#dateFromControl").val();
        let toDate = $("#dateToControl").val();

        datos = datosFiltradosGrafico();
        let filteredLabels = [];
        let filteredData = [];

        originalData.labels.forEach(function (label, index) {
            let date = moment(label);

            if (date.isBetween(fromDate, toDate, null, "[]")) {
                filteredLabels.push(label);
                filteredData.push(originalData.datasets[0].data[index]);
            }
        });

        // Crear nuevos datos filtrados para el gráfico
        let filteredDataSets = [{
            label: originalData.datasets[0].label,
            data: filteredData,
            borderColor: originalData.datasets[0].borderColor,
            backgroundColor: originalData.datasets[0].backgroundColor
        }];

        // Actualizar el gráfico con los datos filtrados
        lineChart.data.labels = filteredLabels;
        lineChart.data.datasets = filteredDataSets;
        lineChart.update();
    }
}