<?php

class Estadisticas
{
    public static function calcular(array $notas)
    {
        $cantidad = count($notas);

        if ($cantidad === 0) {
            return null;
        }

        $promedio = array_sum($notas) / $cantidad;

        $sumaCuadrados = 0;

        foreach ($notas as $nota) {
            $sumaCuadrados += pow($nota - $promedio, 2);
        }

        $desviacion = sqrt($sumaCuadrados / $cantidad);

        return [
            'promedio' => round($promedio, 2),
            'desviacion' => round($desviacion, 2),
            'minimo' => min($notas),
            'maximo' => max($notas)
        ];
    }
}