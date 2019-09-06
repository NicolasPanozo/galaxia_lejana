<?php 
namespace App\Clases;

class Coordenada {
	private $x; // float
	private $y; // float

	public function __construct($x, $y){
		$this->x = $x;
		$this->y = $y;
	}


    /**
     * @return mixed
     */
    public function getX()
    {
    	return $this->x;
    }

    /**
     * @param mixed $x
     *
     * @return self
     */
    public function setX($x)
    {
    	$this->x = $x;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
    	return $this->y;
    }

    /**
     * @param mixed $y
     *
     * @return self
     */
    public function setY($y)
    {
    	$this->y = $y;

    	return $this;
    }

    public function __toString(){
    	return "x: ".$this->getX()." ; y: ".$this->getY();
    }

}


?>