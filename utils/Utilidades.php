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
}