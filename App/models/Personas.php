<?php

class Personas
{
    private $edades;

    public function __construct($edades)
    {
        $this->edades = $edades;
    }

    public function clasificarEdad($edad)
    {
        if($edad >= 0 && $edad <= 12)
        {
            return "Niño";
        }
        elseif($edad <= 17)
        {
            return "Adolescente";
        }
        elseif($edad <= 64)
        {
            return "Adulto";
        }

        return "Adulto Mayor";
    }

    public function obtenerClasificaciones()
    {
        $clasificaciones = [];

        foreach($this->edades as $edad)
        {
            $clasificaciones[] = $this->clasificarEdad($edad);
        }

        return $clasificaciones;
    }

    public function obtenerEstadisticas()
    {
        $estadisticas = [
            "Niños" => 0,
            "Adolescentes" => 0,
            "Adultos" => 0,
            "Adultos Mayores" => 0
        ];

        foreach($this->edades as $edad)
        {
            if($edad <= 12)
            {
                $estadisticas["Niños"]++;
            }
            elseif($edad <= 17)
            {
                $estadisticas["Adolescentes"]++;
            }
            elseif($edad <= 64)
            {
                $estadisticas["Adultos"]++;
            }
            else
            {
                $estadisticas["Adultos Mayores"]++;
            }
        }

        return $estadisticas;
    }

    public function obtenerRepetidas()
    {
        $contador = array_count_values($this->edades);

        $repetidas = [];

        foreach($contador as $edad => $cantidad)
        {
            if($cantidad > 1)
            {
                $repetidas[$edad] = $cantidad;
            }
        }

        return $repetidas;
    }
}