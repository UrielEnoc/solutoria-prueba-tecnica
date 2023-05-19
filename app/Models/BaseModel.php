<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    /**
     * Ejecuta la consulta SQL retornando un arreglo, objeto o booleano según la necesidad del usuario.
     * @param [string] $sentenciaSQL Consulta a ser ejecutada.
     * @param [string] $tipoResultado Escriba 'arreglo' o 'array' para devolver un arreglo, 'objeto' u 'object' para devolver un objeto.
     * @param [string] $modoRetorno Escriba 'arreglo-nulo' o 'array-null' para devolver un arreglo si se ejecuta bien y nulo si no, 'verdadero-falso' o 'true-false' para devolver verdadero si encuentra algún registro y falso si no encuentra nada, 'primer-registro' o 'first-row' para devolver la primera fila encontrada.
     * @param [type] $cerrarDB Escriba 'cerrar conexion' o 'close' para cerrar la conexión.
     * @return array|boolean|null
     */
    public function ejecutarConsulta($sentenciaSQL, $tipoResultado = "arreglo", $modoRetorno = "arreglo-nulo", $cerrarDB = null)
    {
        $resultado = array();

        #Convierte la sentencia a query
        $query = $this->db->query($sentenciaSQL);

        #Ejecuta la query
        if ($tipoResultado == "arreglo" || $tipoResultado == "array") $resultado = $query->getResultArray();
        elseif ($tipoResultado == "objeto" || $tipoResultado == "object") $resultado = $query->getResultObject();
        else die("Error de capa 8.");

        #Verificar el modo de retorno
        if ($resultado != null) {
            switch ($modoRetorno) {
                case 'arreglo-nulo':
                case 'array-null':
                    $resultado; //Nada pasa, se retorna lo que venía.
                    break;
                case 'verdadero-falso':
                case 'true-false':
                    $resultado = true;
                    break;
                case 'primer-registro':
                case 'first-row':
                    $resultado = $resultado[0];
                    break;
                default:
                    die("Error de capa 8.");
                    break;
            }
        } else {
            switch ($modoRetorno) {
                case 'arreglo-nulo':
                case 'array-null':
                    $resultado = null;
                    break;
                case 'verdadero-falso':
                case 'true-false':
                    $resultado = false;
                    break;
                case 'primer-registro':
                case 'first-row':
                    $resultado = null;
                    break;
                default:
                    die("Error de capa 8.");
                    break;
            }
        }

        #Cierra conexión
        if ($cerrarDB == "cerrar conexion" || $cerrarDB == "close_connection") {
            $this->db->close();
        } else if ($cerrarDB != null) {
            die("Error de capa 8.");
        }

        return $resultado;
    }

    /**
     * Ejecuta la sentencia SQL retornando un arreglo, objeto o booleano según la necesidad del usuario.
     * @param [type] $sentenciaSQL Sentencia a ser ejecutada (insert, update, delete, truncate, drop, create...).
     * @param [type] $modoTransaccion Escriba 'iniciar transaccion' o 'trans_start' para iniciar una transacción, 'terminar transaccion' o 'trans_complete' para terminarla.
     * @return boolean La sentencia retorna 'true' o 'false' dependiendo de si funciona bien o no, o de si cierra bien la transacción o no.
     */
    public function ejecutarSentencia($sentenciaSQL, $modoTransaccion = null)
    {
        if ($modoTransaccion == "iniciar transaccion" || $modoTransaccion == "trans_start") {
            #Abre transacción
            $this->db->transStart();
            #Ejecuta la sentencia
            return $this->db->query($sentenciaSQL);
        } else if ($modoTransaccion == "continuar transaccion" || $modoTransaccion == "trans_continue" || $modoTransaccion == null) {
            #Continua la transacción o ejecuta sentencia sin transacción
            return $this->db->query($sentenciaSQL);
        } else if ($modoTransaccion == "terminar transaccion" || $modoTransaccion == "trans_complete") {
            #Ejecuta la sentencia
            $this->db->query($sentenciaSQL);
            #Cierra transacción
            return $this->db->transComplete();
        } else {
            die("Error de capa 8.");
        }
    }

    protected function traerValorSinoNulo($resultado, $registro, $columna = null)
    {
        if ($resultado !== null) {
            if ($columna !== null) return $resultado[$registro][$columna];
            else return $resultado[$registro];
        } else {
            return $resultado;
        }
    }

    public function prepararDatos($arreglo)
    {
        if ($arreglo == null) {
            return null;
        } else {
            foreach ($arreglo as $i => $variable) {
                if (is_array($variable)) {
                    $subArreglo  = $variable;
                    $arreglo[$i] = $this->prepararDatos($subArreglo);
                } else {
                    $arreglo[$i] = addslashes(trim($variable));
                }
            }
            return $arreglo;
        }
    }
    /**
     * Trae todos los datos de un registro de una tabla dada.
     * @param string $tabla Nombre de la tabla.
     * @param string $columnId Nombre de la columna de id.
     * @param string $columnId Valor del id para filtrado.
     * @return string
     */
    protected function tableRow($table, $columnId, $idValue)
    {
        $sql = "SELECT * FROM {$table} WHERE {$columnId} = '{$idValue}'";
        $row = $this->db->query($sql)->getResultArray();
        if ($row !== null) $row = $row[0];
        $this->db->close();
        return $row;
    }

    /**
     * Retorna el id máximo de una tabla de la DB.
     * @param string $tabla Nombre de la tabla.
     * @param string $columnId Nombre de la columna de id.
     * @return string
     */
    protected function maxId($table, $columnId)
    {
        $sql = "SELECT max($columnId) as 'id' FROM " . $table;
        $valor = $this->db->query($sql)->getResultArray();
        if ($valor !== null) $valor = $valor[0]["id"];
        $this->db->close();
        return $valor;
    }

    /**
     * Retorna el id máximo + 1 de una tabla de la DB, equivalente a un nuevo id.
     * @param string $tabla Nombre de la tabla.
     * @param string $columnId Nombre de la columna de id.
     * @return string
     */
    protected function nextId($table, $columnId)
    {
        $sql = "SELECT IFNULL(max($columnId),0)+1 as 'id' FROM " . $table;
        $valor = $this->db->query($sql)->getResultArray();
        if ($valor !== null) $valor = $valor[0]["id"];
        else $valor = 1;
        $this->db->close();
        return $valor;
    }

    protected function select($table, $columns, $where = null, $order = null, $limit = null)
    {
        ($where !== null) ? $stringWhere = $where: $stringWhere = "";
        ($order !== null) ? $stringOrder = $order: $stringOrder = "";
        ($limit !== null) ? $stringLimit = $limit: $stringLimit = "";

        $sql = "SELECT $columns FROM $table $stringWhere $stringOrder $stringLimit";
        $valor = $this->db->query($sql)->getResultArray();
        $this->db->close();
        return $valor;
    }
}
