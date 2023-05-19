<?php

namespace App\Helpers;

class ApiHelper
{
    private function consumirApi(string $tipoSolicitud, string $url, array $data, array $headers)
    {
        // Inicializar la solicitud cURL
        $ch = curl_init();

        // Establecer la URL de la solicitud
        curl_setopt($ch, CURLOPT_URL, $url);

        // Establecer el método de la solicitud
        curl_setopt($ch, CURLOPT_POST, true);

        // Configurar la solicitud en función del tipo de solicitud
        switch ($tipoSolicitud) {
            case "GET":
                // Establecer el método de la solicitud (GET)
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                // Establecer el método de la solicitud (POST)
                curl_setopt($ch, CURLOPT_POST, true);
                // Establecer los datos a enviar en la solicitud POST
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                // Establecer los encabezados de la solicitud (si es necesario)
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'accept: */*',
                    'Content-Type: application/json-patch+json'
                ));
                break;
            case "PUT":
                // Establecer el método de la solicitud (PUT)
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                // Establecer los datos a enviar en la solicitud PUT
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                // Establecer los encabezados de la solicitud (si es necesario)
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'accept: */*',
                    'Content-Type: application/json-patch+json'
                ));
                break;
            case "DELETE":
                // Establecer el método de la solicitud (DELETE)
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                // Tipo de solicitud no válido
                echo "Tipo de solicitud no válido";
                exit;
        }

        // Establecer los encabezados de la solicitud
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Establecer la opción para recibir la respuesta de la solicitud
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la solicitud cURL y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hay errores en la solicitud
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        }

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Procesar la respuesta
        if ($httpCode == 200) {
            // La solicitud fue exitosa
            $resp["mensaje"] = '<b>Acceso exitoso.</b> los datos se cargan.';
            $resp["response"] = $response;
            $resp["httpCode"] = 200;
        } else {
            // La solicitud falló
            $resp["mensaje"] = '<b>Sin acceso</b> el usuario no es válido.';
            $resp["response"] = null;
            $resp["httpCode"] = $httpCode;
        }

        return $resp;
    }

    public function conexionApiAcceso($data)
    {
        $api = new ApiHelper();

        // URL de la API REST
        $url = "https://postulaciones.solutoria.cl/api/acceso";

        // Establecer los encabezados de la solicitud
        $header = array(
            'accept: */*',
            'Content-Type: application/json-patch+json'
        );

        return $api->consumirApi("POST", $url, $data, $header);
    }
    public function conexionApiUF($token)
    {
        $api = new ApiHelper();

        // URL de la API REST
        $url = "https://postulaciones.solutoria.cl/api/indicadores";
        // Datos para enviar en la solicitud POST
        $data = array();
        // Establecer los encabezados de la solicitud
        $header = array(
            "Authorization: Bearer {$token}",
            'accept: */*',
            'Content-Type: application/json-patch+json'
        );

        return $api->consumirApi("GET", $url, $data, $header);
    }
}
