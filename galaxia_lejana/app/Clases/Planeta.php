<?php 
namespace App\Clases;

class Planeta {
	private $nombre; // string
	private $coordenada; // Coordenada
	private $velocidad_angular; // int
    private $radio; // int

    public function __construct($nombre, $coordenada, $velocidad_angular, $radio){
      $this->nombre = $nombre;
      $this->coordenada = $coordenada;
      $this->velocidad_angular = $velocidad_angular;
      $this->radio = $radio;
  }


    /**
     * @return mixed
     */
    public function getNombre()
    {
    	return $this->nombre;
    }

    /**
     * @param mixed $nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
    	$this->nombre = $nombre;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getCoordenada()
    {
    	return $this->coordenada;
    }

    /**
     * @param mixed $coordenada
     *
     * @return self
     */
    public function setCoordenada($coordenada)
    {
    	$this->coordenada = $coordenada;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVelocidadAngular()
    {
    	return $this->velocidad_angular;
    }



    /**
     * @return mixed
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * @param mixed $radio
     *
     * @return self
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;

        return $this;
    }


    public function __toString(){
        return "( Nombre: ".$this->getNombre()." - Velocidad angular: ".$this->getVelocidadAngular()." - Radio: ".$this->getRadio()." - Coordenada: ".$this->getCoordenada()->__toString()." )";
    }
    
}


?>