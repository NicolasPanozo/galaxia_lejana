<?php 
namespace App\Clases;

class Estrella {
	private $nombre; // string
	private $coordenada; // Coordenada

	public function __construct($nombre, $coordenada){
		$this->nombre = $nombre;
		$this->coordenada = $coordenada;
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

    public function __toString(){
    	return "( Nombre: ".$this->getNombre()." Coordenada: ".$this->getCoordenada()->__toString()." )";
    }

}

?>