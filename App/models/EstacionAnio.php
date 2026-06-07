<?php

class EstacionAnio
{
    public static function obtenerEstacion($fecha)
    {
        $timestamp = strtotime($fecha);

        $dia = (int) date('d', $timestamp);
        $mes = (int) date('m', $timestamp);

        if (
            ($mes == 9 && $dia >= 23) ||
            ($mes == 10) ||
            ($mes == 11) ||
            ($mes == 12 && $dia <= 20)
        ) {
            return [
                'nombre' => 'Primavera',
                'imagen' => 'primavera.jpeg'
            ];
        }

        if (
            ($mes == 12 && $dia >= 21) ||
            ($mes == 1) ||
            ($mes == 2) ||
            ($mes == 3 && $dia <= 20)
        ) {
            return [
                'nombre' => 'Verano',
                'imagen' => 'verano.jpg'
            ];
        }

        if (
            ($mes == 3 && $dia >= 21) ||
            ($mes == 4) ||
            ($mes == 5) ||
            ($mes == 6 && $dia <= 20)
        ) {
            return [
                'nombre' => 'Otoño',
                'imagen' => 'otono.jpg'
            ];
        }

        return [
            'nombre' => 'Invierno',
            'imagen' => 'invierno.jpg'
        ];
    }
}