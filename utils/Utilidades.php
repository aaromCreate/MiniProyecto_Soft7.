<?php
/*

Esto cubre:

métodos estáticos,
clases,
validaciones,
OWASP,
DRY y demas

*/
class Utilidades
{
    public static function sanitizarTexto($texto)
    {
        return htmlspecialchars(trim($texto));
    }

    public static function validarNumero($numero)
    {
        return filter_var($numero, FILTER_VALIDATE_FLOAT);
    }

    public static function calcularPromedio($numeros)
    {
        return array_sum($numeros) / count($numeros);
    }

    public static function desviacionEstandar($numeros)
    {
        $promedio = self::calcularPromedio($numeros);

        $suma = 0;

        foreach ($numeros as $numero) {

            $suma += pow($numero - $promedio, 2);

        }

        return sqrt($suma / count($numeros));
    }
}