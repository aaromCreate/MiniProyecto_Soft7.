<?php

class Potencias
{
    public static function generar($numero)
    {
        $potencias = [];

        for ($i = 1; $i <= 15; $i++) {

            $potencias[] = [
                'exponente' => $i,
                'resultado' => pow($numero, $i)
            ];
        }

        return $potencias;
    }
}