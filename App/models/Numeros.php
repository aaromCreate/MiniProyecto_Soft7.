<?php
// App/models/Numeros.php

class Numeros
{
    private $elementos;

    // El constructor recibe el array con los 5 números positivos acumulados
    public function __construct($elementos)
    {
        $this->elementos = $elementos;
    }

    // Calcula la media aritmética (promedio)
    public function calcularMedia()
    {
        if (count($this->elementos) === 0)
            return 0;
        return array_sum($this->elementos) / count($this->elementos);
    }

    // Calcula la desviación estándar
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

    // Obtiene el número más pequeño del arreglo
    public function obtenerMinimo()
    {
        if (count($this->elementos) === 0)
            return 0;
        return min($this->elementos);
    }

    // Obtiene el número más grande del arreglo
    public function obtenerMaximo()
    {
        if (count($this->elementos) === 0)
            return 0;
        return max($this->elementos);
    }
    /**
     * Problema 2: Calcula la suma de los números del 1 al 1,000
     * @return int
     */
    public function calcularSumaHastaMil()
    {
        $suma = 0;
        for ($i = 1; $i <= 1000; $i++) {
            $suma += $i;
        }
        return $suma;
    }
    /**
     * Problema 3: Genera los N primeros múltiplos de 4 y detecta desbordamientos
     * @param int $cantidad
     * @return array
     */
    public function generarMultiplosDeCuatro($cantidad)
    {
        $multiplos = [];
        for ($i = 1; $i <= $cantidad; $i++) {
            $resultado = 4 * $i;

            // Evaluar conceptualmente si ocurre desbordamiento (Overflow)
            // Si el resultado pasa a ser un Float o se vuelve infinito/negativo por límite de bits
            if (is_infinite($resultado) || !is_int($resultado) || $resultado < 0) {
                $multiplos[$i] = "Desbordamiento (Límite superado)";
                break; // Romper el ciclo para proteger la memoria del servidor
            }

            $multiplos[$i] = $resultado;
        }
        return $multiplos;
    }
    // Atributos adicionales para el manejo de rangos (Problema 4)
    private $inicio;
    private $fin;

    /**
     * Inicializa un rango dinámico para el Problema 4
     */
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