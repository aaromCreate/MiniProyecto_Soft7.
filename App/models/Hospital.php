<?php

class Hospital
{
    private $ginecologia;
    private $traumatologia;
    private $pediatria;

    public function __construct($ginecologia, $traumatologia, $pediatria)
    {
        $this->ginecologia = $ginecologia;
        $this->traumatologia = $traumatologia;
        $this->pediatria = $pediatria;
    }

    public function obtenerTotal()
    {
        return $this->ginecologia +
               $this->traumatologia +
               $this->pediatria;
    }

    public function porcentajeGinecologia()
    {
        return ($this->ginecologia / $this->obtenerTotal()) * 100;
    }

    public function porcentajeTraumatologia()
    {
        return ($this->traumatologia / $this->obtenerTotal()) * 100;
    }

    public function porcentajePediatria()
    {
        return ($this->pediatria / $this->obtenerTotal()) * 100;
    }
}