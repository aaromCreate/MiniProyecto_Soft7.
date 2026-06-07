<?php
// App/models/Numeros.php

class Numeros
{
    private $elementos;

    public function __construct($elementos)
    {
        $this->elementos = $elementos;
    }

    public function calcularMedia()
    {
        if (count($this->elementos) === 0)
            return 0;
        return array_sum($this->elementos) / count($this->elementos);
    }

    public function calcularDesviacionEstandar()
    {
        $totalElementos = count($this->elementos);
        if ($totalElementos === 0)
            return 0;

        $promedio = $this->calcularMedia();
        $sumaCuadrados = 0;

        foreach ($this->elementos as $numero) {
            $sumaCuadrados += pow($numero - $promedio, 2);
        }

        return sqrt($sumaCuadrados / $totalElementos);
    }

    public function obtenerMinimo()
    {
        if (count($this->elementos) === 0)
            return 0;
        return min($this->elementos);
    }

    public function obtenerMaximo()
    {
        if (count($this->elementos) === 0)
            return 0;
        return max($this->elementos);
    }

    public function calcularSumaHastaMil()
    {
        $suma = 0;
        for ($i = 1; $i <= 1000; $i++) {
            $suma += $i;
        }
        return $suma;
    }

    public function generarMultiplosDeCuatro($cantidad)
    {
        $multiplos = [];
        for ($i = 1; $i <= $cantidad; $i++) {
            $resultado = 4 * $i;

            //si ocurre desbordamiento (Overflow)
            // Si el resultado pasa a ser un Float o se vuelve infinito/negativo por límite de bits
            if (is_infinite($resultado) || !is_int($resultado) || $resultado < 0) {
                $multiplos[$i] = "Desbordamiento (Límite superado)";
                break; // Romper el ciclo para proteger la memoria del servidor
            }

            $multiplos[$i] = $resultado;
        }
        return $multiplos;
    }

    private $inicio;
    private $fin;
    public function inicializarRango($inicio, $fin)
    {
        $this->inicio = (int) $inicio;
        $this->fin = (int) $fin;
    }

    public function sumarPares()
    {
        $suma = 0;
        for ($i = $this->inicio; $i <= $this->fin; $i++) {
            if ($i % 2 == 0) {
                $suma += $i;
            }
        }
        return $suma;
    }

    public function sumarImpares()
    {
        $suma = 0;
        for ($i = $this->inicio; $i <= $this->fin; $i++) {
            if ($i % 2 != 0) {
                $suma += $i;
            }
        }
        return $suma;
    }

    public function obtenerPares()
    {
        $pares = [];
        for ($i = $this->inicio; $i <= $this->fin; $i++) {
            if ($i % 2 == 0) {
                $pares[] = $i;
            }
        }
        return $pares;
    }

    public function obtenerImpares()
    {
        $impares = [];
        for ($i = $this->inicio; $i <= $this->fin; $i++) {
            if ($i % 2 != 0) {
                $impares[] = $i;
            }
        }
        return $impares;
    }
}