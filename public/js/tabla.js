function initTable() {
    //Estoy aburrido de la vida

    $("#tableUF").DataTable({
        "paging": true,
        "pageLength": 10,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "retrieve": true,
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
        },
    });
    
    setTimeout(function () {
        $("#tableUF").DataTable().draw();
    }, 1000); //Si conocen una forma más elegante de hacer esto, me la dicen, porque la desconozco
}