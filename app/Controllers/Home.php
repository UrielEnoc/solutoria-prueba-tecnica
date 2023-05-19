<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UFModel;
use App\Helpers\ApiHelper;
use App\Helpers\TestHelper as Test;

class Home extends BaseController
{
    private $model;
    private $api;

    public function __construct()
    {
        $this->model = new UFModel();
        $this->api = new ApiHelper();
    }

    public function index()
    {
        return view('home');
    }

    public function traerIndicadores()
    {
        // Datos para enviar en la solicitud POST
        $data = array_map("trim", esc($this->request->getPost())); //urielolivaresby5s9_4mm@indeedemail.com
        $data["flagJson"] = true;

        $resultado = $this->api->conexionApiAcceso($data);
        if ($resultado["httpCode"] == 200) {
            $token = json_decode($resultado["response"])->token;
            $dataIndicadores = json_decode($this->api->conexionApiUF($token)["response"]);
            if (empty($dataIndicadores)) {
                $resultado["mensaje"] = '<b>Fallo inesperado</b> no se cargaron datos de UF.';
                $resultado["response"] = null;
                $resultado["httpCode"] = 404;
            } else {
                $dataUF = $this->extraerUFDeIndicadores($dataIndicadores);
                $this->model->insertUFs($dataUF);
                $resultado["mensaje"] = '<b>Éxito </b> se cargan las UFs.';
                $resultado["response"] = $this->model->getUFs();
                $resultado["httpCode"] = 200;
            }
        }
        echo json_encode($resultado);
    }

    private function extraerUFDeIndicadores($dataIndicadores)
    {
        $uf = array();
        $ufs = array();
        foreach ($dataIndicadores as $indicador) {
            if ($indicador->codigoIndicador === "UF") {
                $uf["nombre"]   = $indicador->nombreIndicador;
                $uf["codigo"]   = $indicador->codigoIndicador;
                $uf["unidad"]   = $indicador->unidadMedidaIndicador;
                $uf["valor"]    = $indicador->valorIndicador;
                $uf["fecha"]    = $indicador->fechaIndicador;
                $uf["tiempo"]   = $indicador->tiempoIndicador;
                $uf["origen"]   = $indicador->origenIndicador;

                array_push($ufs, $uf);
            }
        }
        return $ufs;
    }

    public function listarIndicadores()
    {
        $resultado["response"] = $this->model->getUFs();
        echo json_encode($resultado);
    }

    private function validarDatos($data)
    {
        $resultado = array();

        /* Validaciones CI4 */
        $validation = Services::validation();
        $validation->setRules([
            'uf-valor' => [
                'rules'  => 'required|decimal|regex_match[/^(?:0|[1-9]\d*)(?:\.\d+)?$/]',
                'errors' => [
                    'required' => 'Debe ingresar un valor.',
                    'decimal' => 'El valor no es un decimal.',
                    'regex_match' => 'El valor no puede ser menor a 0.',
                ],
            ],
            'uf-fecha' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required' => 'Debe ingresar una fecha.',
                    'valid_date' => 'Debe ingresar una fecha válida.',
                ],
            ],
        ]);

        if (!$validation->run($data)) $resultado["errors"] = $validation->getErrors();
        else $resultado["errors"] = null;

        $newData["codigo"]      = "UF";
        $newData["nombre"]      = "UNIDAD DE FOMENTO (UF)";
        $newData["unidad"]      = "Pesos";
        $newData["valor"]       = $data["uf-valor"];
        $newData["fecha"]       = $data["uf-fecha"];
        $newData["tiempo"]      = null;
        $newData["origen"]      = "solutoria.cl";
        $resultado["campos"]    = $newData;

        return $resultado;
    }

    public function agregarIndicador()
    {
        // Datos para enviar en la solicitud POST
        $dataPost = array_map("trim", esc($this->request->getPost()));
        $data = $this->validarDatos($dataPost);

        if (is_null($data["errors"])) {
            $this->model->addUF($data["campos"]);
            $resultado["exito"] = true;
            $resultado["icono"] = "iconSuccess";
            $resultado["color"] = "green";
            $resultado["titulo"] = "Éxito";
            $resultado["mensaje"] = "¡La nueva UF ha sido guardada!";
        } else {
            $resultado["exito"] = true;
            $resultado["icono"] = "iconError";
            $resultado["color"] = "red";
            $resultado["titulo"] = "Error";
            $resultado["mensaje"] = "Hubo un error inesperado.";
        }
        echo json_encode($resultado);
    }

    public function editarIndicador()
    {
        // Datos para enviar en la solicitud POST
        $dataPost = array_map("trim", esc($this->request->getPost()));
        $data = $this->validarDatos($dataPost);

        $data["campos"]["id"] = $dataPost["uf-id"];
        if (!$this->model->existeUF($dataPost["uf-id"])) $data["errors"] = true;

        if (is_null($data["errors"])) {
            $this->model->editUF($data["campos"]);
            $resultado["exito"] = true;
            $resultado["icono"] = "iconSuccess";
            $resultado["color"] = "green";
            $resultado["titulo"] = "Éxito";
            $resultado["mensaje"] = "¡La UF ha sido actualizada!";
        } else {
            $resultado["exito"] = true;
            $resultado["icono"] = "iconError";
            $resultado["color"] = "red";
            $resultado["titulo"] = "Error";
            $resultado["mensaje"] = "Hubo un error inesperado.";
        }
        echo json_encode($resultado);
    }

    public function eliminarIndicador()
    {
        $id = trim(esc($this->request->getPost("id")));

        if ($this->model->deleteUF($id)) {
            $result["exito"] = true;
            $result["icono"] = "iconSuccess";
            $result["color"] = "green";
            $result["titulo"] = "Éxito";
            $result["mensaje"] = "La UF ha sido eliminada!";
        } else {
            $result["exito"] = true;
            $result["icono"] = "iconError";
            $result["color"] = "red";
            $result["titulo"] = "Error";
            $result["mensaje"] = "Hubo un error inesperado.";
        }
        echo json_encode($result);
    }
}
