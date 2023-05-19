<!doctype html>
<html lang="es" data-bs-theme="oo">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Solutoria UF</title>
    <link href="<?= base_url("/public/css/estilos.css") ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url("/public/css/estilos.css") ?>" />
    <script src="<?= base_url("/public/js/loader.js") ?>"></script>

    <script>
        const baseUrl = "<?= base_url() ?>";
        const iconSuccess = "fa fa-check-circle";
        const iconExclamation = "fas fa-exclamation-circle";
        const iconError = "fa fa-times-circle";
    </script>
</head>

<body>
    <header class="header py-4">
        <h1 id="title" class="text-center">
            <img id="logo-solutoria" src="<?= base_url("/public/img/SigmaSquare.jpg") ?>" alt="log-solutoria">
            SOLUTORIA UF
        </h1>
        <p id="description" class="description text-center">
            Prueba técnica para proceso de selección
        </p>

        <ul class="nav justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Cargar y listar UF</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Agregar UF</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Ver gráfico</button>
            </li>
        </ul>
    </header>


    <div id="mainSection" class="container px-0 shadow">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <?= view("/componentes/tabTable.html") ?>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <?= view("/componentes/tabFormAdd.html") ?>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <?= view("/componentes/tabChart.html") ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="row">
            <div class="col-12 col-md-6 pt-5 mt-5 ps-5 text-white text-start">
                <h5>CONTACTO</h5>
                <div>
                    <p class="pt-2">Nombre: Uriel Olivares Silva</p>
                </div>
                <div class="li-contact">
                    <i class="fab fa-linkedin"></i>
                    <a class="text-white" href="https://www.linkedin.com/in/uolivaress/">
                        Linkedin
                    </a>
                </div>
                <div class="li-contact">
                    <i class="fas fa-phone"></i>
                    <a class="text-white" href="tel:+56982010907">
                        +56 9 8201 0907
                    </a>
                </div>
                <div class="li-contact">
                    <i class="far fa-envelope"></i>
                    <a class="text-white" href="mailto:urielenoc@outlook.com" target="_blank">
                        urielenoc@outlook.com
                    </a>
                </div>
            </div>
            <div class="d-none d-md-block col-md-6">
                <img id="gaton" src="<?= base_url("/public/img/gato.png") ?>" alt="">
            </div>
        </div>
    </footer>

    <script src="<?= base_url("/public/js/general.js") ?>"></script>
    <script src="<?= base_url("/public/js/tabla.js") ?>"></script>
    <script src="<?= base_url("/public/js/grafico.js") ?>"></script>
    <script src="<?= base_url("/public/js/uf-create.js") ?>"></script>
    <script src="<?= base_url("/public/js/uf-read.js") ?>"></script>
    <script src="<?= base_url("/public/js/uf-update.js") ?>"></script>
    <script src="<?= base_url("/public/js/uf-delete.js") ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</body>

</html>