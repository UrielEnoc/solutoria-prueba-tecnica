<?php

namespace App\Helpers;

class TestHelper
{
    private $defaultTextoAnterior;
    private $defaultArreglo;
    private $dafaultVarDump;
    private $defaultTextoPosterior;
    private $defaultEstilo;
    private $defaultTamano;
    private $defaultColor;
    private $defaultParar;

    public function __construct()
    {
        $this->defaultTextoAnterior     = "";
        $this->defaultArreglo           = null;
        $this->dafaultVarDump           = false;
        $this->defaultTextoPosterior    = "";
        $this->defaultEstilo            = "";
        $this->defaultTamano            = 14;
        $this->defaultColor             = "black";
        $this->defaultParar             = "";
    }

    private function procesarFormato($estilo, $tamano, $color)
    {
        $formato = array(
            "b"     => array(0 => "", 1 => ""),
            "i"     => array(0 => "", 1 => ""),
            "u"     => array(0 => "", 1 => ""),
            "size"  => $this->defaultTamano,
            "color" => $this->defaultColor,
        );

        $bold       = stripos($estilo, "b");
        $italic     = stripos($estilo, "i");
        $underline  = stripos($estilo, "u");

        if ($bold !== false) { //No funciona con '=== true' WTF
            $formato["b"][0] = "<b>";
            $formato["b"][1] = "</b>";
        }
        if ($italic !== false) { //No funciona con '=== true' WTF
            $formato["i"][0] = "<i>";
            $formato["i"][1] = "</i>";
        }
        if ($underline !== false) { //No funciona con '=== true' WTF
            $formato["u"][0] = "<u>";
            $formato["u"][1] = "</u>";
        }

        if (intval($tamano) == true) $formato["size"] = $tamano;

        if ($color != null && $color != "") $formato["color"] = $color;


        return $formato;
    }

    private function imprimirDeBajoNivel($texto_anterior = "", $arreglo = null, $var_dump = false, $texto_posterior = "", $estilo = "", $tamano = "12", $color = "black", $parar = "")
    {
        $formato = $this->procesarFormato($estilo, $tamano, $color);

        echo "<pre style='color: {$formato['color']}; font-size: {$formato['size']}px;'>";
        echo "{$formato['b'][0]}{$formato['i'][0]}{$formato['u'][0]}";

        if ($texto_anterior != null)                 print($texto_anterior);
        if ($arreglo != null && $var_dump == false)  print_r($arreglo);
        if ($arreglo != null && $var_dump == true)   var_dump($arreglo);
        if ($texto_posterior != null)                print($texto_posterior);

        echo "{$formato['u'][1]}{$formato['i'][1]}{$formato['b'][1]}";
        echo "</pre>";

        $this->finalizarTest($parar);
    }

    private function finalizarTest($intruccion)
    {
        if ($intruccion == "die" || $intruccion == "exit") die();
    }


    /**
     * Imprime texto y da la posibilidad de darle formato.
     * @param string $texto_anterior Texto a mostrar.
     * @param string $parar Si el código debe detenerse o no. Escribir "die" o "exit" para detenerlo.
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir($texto, $parar = null, $estilo = null, $tamano = null, $color = null)
    {
        $t = new TestHelper();
        $t->imprimirDeBajoNivel($texto, null, false, null, $estilo, $tamano, $color, $parar);
    }

    /**
     * Imprime un arreglo con detalle y da la posibilidad de darle formato.
     * @param array|mixed $arreglo Arreglo a imprimir con detalle. También se puede pasar una variable normal.
     * @param string $parar Si el código debe detenerse o no. Escribir "die" o "exit" para detenerlo.
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir_arreglo($arreglo, $parar = null, $estilo = null, $tamano = null, $color = null)
    {
        $t = new TestHelper();
        $t->imprimirDeBajoNivel(null, $arreglo, false, null, $estilo, $tamano, $color, $parar);
    }

    /**
     * Imprime el detalle de un arreglo entre medio de texto y da la posibilidad de darle formato.
     * @param string $texto_anterior Texto a mostrar.
     * @param array|mixed $arreglo Arreglo a imprimir con detalle. También se puede pasar una variable normal.
     * @param string $texto_posterior Texto a mostrar luego de detallar el arreglo.
     * @param string $parar Si el código debe detenerse o no. Escribir "die" o "exit" para detenerlo.
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir_arreglo_entre_texto($texto_anterior, $arreglo, $texto_posterior = null, $parar = null, $estilo = null, $tamano = null, $color = null)
    {
        $t = new TestHelper();
        $t->imprimirDeBajoNivel($texto_anterior, $arreglo, false, $texto_posterior, $estilo, $tamano, $color, $parar);
    }

    /**
     * Imprime el detalle de un arreglo y luego texto y da la posibilidad de darle formato.
     * @param array|mixed $arreglo Arreglo a imprimir con detalle. También se puede pasar una variable normal.
     * @param string $texto_posterior Texto a mostrar luego de detallar el arreglo.
     * @param string $parar Si el código debe detenerse o no. Escribir "die" o "exit" para detenerlo.
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir_arreglo_luego_texto($arreglo, $texto_posterior, $parar = null, $estilo = null, $tamano = null, $color = null)
    {
        $t = new TestHelper();
        $t->imprimirDeBajoNivel(null, $arreglo, false, $texto_posterior, $estilo, $tamano, $color, $parar);
    }

    /**
     * Imprime var_dump y da la posibilidad de darle formato.
     * @param mixed $variable Variable o arreglo a detallarse con var_dump.
     * @param string $parar Si el código debe detenerse o no. Escribir "die" o "exit" para detenerlo.
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir_var_dump($variable, $parar = null, $estilo = null, $tamano = null, $color = null)
    {
        $t = new TestHelper();
        $t->imprimirDeBajoNivel(null, $variable, true, null, $estilo, $tamano, $color, $parar);
    }

    /**
     * Imprime una carita y da la posibilidad de darle formato.
     * @param mixed $tipo Variable o arreglo a detallarse con var_dump.
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function imprimir_carita($tipo = null, $color = "black", $tamano = 14)
    {
        echo "<pre style='color: {$color}; font-size: {$tamano}px;''>";
        switch ($tipo) {
            case 'feliz' || 1:
                print("=)");
                break;
            case 'alegre' || 2:
                print(":D");
                break;
            case 'triste' || 3:
                print(":c");
                break;
            case 'enojada' || 4:
                print(">:c");
                break;
            case 'sorprendida' || 5:
                print(":O");
                break;
            default:
                print(":)");
                break;
        }
        echo "</pre>";
    }

    /**
     * Imprime alert con un texto por defecto, sin tener que andar escribiendo las etiquetas. Además ofrece la posibildidad de activarlo o desactivarlo.
     * @param boolean $activar True: muestra el alert, False: ya no lo muestra.
     * @param boolean $etiquetas True: muestra el alert dentro de etiquetas <script></script>, False: no muestra las etiquetas.
     * @param string $texto Texto a mostrar. null = ¡Alerta!
     * @return void
     */
    static function alert($activar = true, $etiquetas = true, $texto = null)
    {
        if ($activar) {
            if ($texto == null) $texto = "¡Alerta!";
            if ($etiquetas) {
                print "<script>alert(`{$texto}`);</script>";
            } else {
                print "alert(`{$texto}`);";
            }
        }
    }

    /**
     * Imprime console.log() con un texto por defecto, sin tener que andar escribiendo las etiquetas. Además ofrece la posibildidad de activarlo o desactivarlo y darle formato.
     * @param boolean $activar True: muestra el alert, False: ya no lo muestra.
     * @param boolean $etiquetas True: muestra el alert dentro de etiquetas <script></script>, False: no muestra las etiquetas.
     * @param string $texto Texto a mostrar. null = ¡Alerta!
     * @param string $estilo Estilo del texto. Coloque 'b' para texto en negrita, 'i' para texto en cursiva y 'u' para texto subrayado. Ej: "b", "ui", "iu", "biu" "bi".
     * @param int $tamano Tamaño en px del texto.
     * @param string $color Color HTML, puede ser en formato hexagecimal o con nombre de color.
     * @return void
     */
    static function console_log($activar = true, $etiquetas = true, $texto = null, $color = null, $estilo = null, $tamano = null)
    {
        if ($activar) {

            if ($texto == null && $tamano === null) {
                $texto  = "😱";
                $tamano = "30px";
            }
            if ($texto == null && $tamano != null) {
                $texto  = "👀";
            }
            $icono = null;

            switch ($color) {
                case "success":
                    $color = "color: Green;";
                    $icono = "🟢";
                    break;
                case "info":
                    $color = "color: DodgerBlue;";
                    $icono = "🔵";
                    break;
                case "error":
                    $color = "color: Red;";
                    $icono = "🔴";
                    break;
                case "warning":
                    $color = "color: Orange;";
                    $icono = "🟡";
                default:
                    $color = "color: {$color};";
                    break;
            }

            switch ($tamano) {
                case 'xs':
                    $tamano = "font-size: 10px;";
                    break;
                case "sm":
                    $tamano = "font-size: 12px;";
                    break;
                case "md":
                    $tamano = "font-size: 14px;";
                    break;
                case "lg":
                    $tamano = "font-size: 16px;";
                    break;
                case "xl":
                    $tamano = "font-size: 20px;";
                    break;
                case "xxl":
                    $tamano = "font-size: 24px;";
                    break;
                default:
                    $tamano = "font-size: {$tamano}px;";
                    break;
            }

            $bold       = stripos($estilo, "b");
            $italic     = stripos($estilo, "i");
            $underline  = stripos($estilo, "u");

            $bold       !== false ? $bold       = "font-weight: bold;"          : $bold = "";
            $italic     !== false ? $italic     = "font-style: italic;"         : $italic = "";
            $underline  !== false ? $underline  = "text-decoration: underline;" : $underline = "";

            $css = "{$color} {$tamano} {$bold} {$italic} {$underline}";

            if ($etiquetas) print "<script>console.log(`{$icono} %c{$texto}`,`{$css}`);</script>";
            else print "console.log(`%c{$icono} {$texto}`,`{$css}`);";
        }
    }

    /**
     * Imprime saltos de línea.
     * @param int $cantidad Cantidad de saltos de línea a imprimir
     * @return void
     */
    static function imprimir_saltos_de_linea($cantidad)
    {
        for ($i = 0; $i < $cantidad; $i++) {
            echo "<br>";
        }
    }

    /**
     * Detiene la ejecución del código. Equivale a die() o exit()
     * @param string $texto Texto a mostrar cuando se detenga la ejecución.
     * @return void
     */
    static function parar($texto = null)
    {
        die($texto);
    }
}
