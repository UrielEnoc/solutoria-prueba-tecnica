<?php

namespace App\Models;

use App\Helpers\TestHelper as Test;

class UFModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    #### INSERT_______________
    public function insertUFs($ufs)
    {
        //Recargando los datos por completo e iniciando la transacción
        #$sql = "TRUNCATE TABLE indicadores";
        $sql = "DELETE FROM indicadores WHERE origen = 'mindicador.cl'";
        $this->ejecutarSentencia($sql, "iniciar transaccion");

        $ultimoRegistro = count($ufs) - 1;

        for ($indice = 0; $indice <= $ultimoRegistro; $indice++) {
            $nombre     = $ufs[$indice]["nombre"];
            $codigo     = $ufs[$indice]["codigo"];
            $unidad     = $ufs[$indice]["unidad"];
            $valor      = $ufs[$indice]["valor"];
            $fecha      = $ufs[$indice]["fecha"];
            $tiempo     = $ufs[$indice]["tiempo"];
            $origen     = $ufs[$indice]["origen"];

            //Insertando datos
            $sql = "INSERT INTO indicadores(nombre, codigo, unidad, valor, fecha, tiempo, origen)
                        VALUES ('{$nombre}', '{$codigo}', '{$unidad}', '{$valor}', '{$fecha}', '{$tiempo}', '{$origen}')";

            if ($indice < $ultimoRegistro) $this->ejecutarSentencia($sql);
            elseif ($indice === $ultimoRegistro) $this->ejecutarSentencia($sql, "terminar transaccion");
        }
    }

    public function addUF($uf)
    {
        //Insertando datos
        $sql = "INSERT INTO indicadores(nombre, codigo, unidad, valor, fecha, tiempo, origen)
        VALUES ('{$uf["nombre"]}', '{$uf["codigo"]}', '{$uf["unidad"]}', '{$uf["valor"]}', '{$uf["fecha"]}', '{$uf["tiempo"]}', '{$uf["origen"]}')";
        $this->ejecutarSentencia($sql);
    }

    #### SELECT_______________
    public function existeUF($id)
    {
        $sql = "SELECT * FROM indicadores WHERE id = {$id}";
        return $this->ejecutarConsulta($sql, "array", "verdadero-falso");
    }

    public function getUFs()
    {
        $sql = "SELECT * FROM indicadores ORDER BY fecha DESC";
        return $this->ejecutarConsulta($sql, "array", "arreglo-nulo");
    }

    #### UPDATE_______________
    public function editUF($uf)
    {
        $sql = "UPDATE indicadores SET valor = '{$uf["valor"]}', fecha = '{$uf["fecha"]}' WHERE id = '{$uf["id"]}'";
        return $this->ejecutarSentencia($sql);
    }

    #### DELETE_______________
    public function deleteUF($id)
    {
        $sql = "DELETE FROM indicadores where id = {$id}";
        return $this->ejecutarSentencia($sql);
    }
}
