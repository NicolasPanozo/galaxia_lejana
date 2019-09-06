<?php 
namespace App\Clases;



class Galaxia {
    const DIAS_DEL_ANIO = 360; // Un año en esta galaxia sera lo que tarda en dar la vuelta al sol el planeta Ferengi.
	private $nombre; // string
	private $planetas; // Array('F', 'V', 'B')
	private $estrella; // Estrella (sol)

    const SEQUIA = 1;
    const COND_OPTIMAS = 2;
    const LLUVIA = 3;
    const INDEFINIDO = 4;

    public function __construct($nombre, $planetas, $estrella){
      $this->nombre = $nombre;
      $this->planetas = $planetas;
      $this->estrella = $estrella;
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
    public function getPlanetas()
    {
        return $this->planetas;
    }

    /**
     * @param mixed $planetas
     *
     * @return self
     */
    public function setPlanetas($planetas)
    {
        $this->planetas = $planetas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstrella()
    {
        return $this->estrella;
    }

    /**
     * @param mixed $estrella
     *
     * @return self
     */
    public function setEstrella($estrella)
    {
        $this->estrella = $estrella;

        return $this;
    }

    public function __toString(){
    	return "Galaxia: ".$this->getNombre()." - Planetas: ".implode(", ", $this->getPlanetas())." - Estrella: ".$this->getEstrella();
    }


    private function isTresPuntosAlineados($coor1, $coor2, $coor3){ // Retorna true si los tres puntos estan alineados.
        $var_a = ($coor3->getY() - $coor2->getY())*($coor2->getX() - $coor1->getX());
        $var_b = ($coor2->getY() - $coor1->getY())*($coor3->getX() - $coor2->getX());
        if($var_a == $var_b ){ return true; }else{ return false; }
    }

    private function setearCoordenada($planeta, $t){ // Calcula las coordenadas cartesiandas de cada planeta, en base a su velocidad angular (w) en grados/dias, y el tiempo (t) en días y se las asigna. Se redondean a dos decimales.
        // Coordenadas = P(x,y) siendo, x = r.cos(wt), y = r.sen(wt)
        $w = $planeta->getVelocidadAngular();
        $r = $planeta->getRadio();

        $x = round($r*cos(deg2rad($w*$t))*100)/100;
        $y = round($r*sin(deg2rad($w*$t))*100)/100;

        $planeta->setCoordenada(new Coordenada($x, $y));

    }

    private function isPuntoDentroTriangulo($coorF, $coorV, $coorB, $coorP){
        $fvb = (($coorF->getX() - $coorB->getX())*($coorV->getY() - $coorB->getY())) - (($coorF->getY() - $coorB->getY())*($coorV->getX() - $coorB->getX()));

        $fvp = (($coorF->getX() - $coorP->getX())*($coorV->getY() - $coorP->getY())) - (($coorF->getY() - $coorP->getY())*($coorV->getX() - $coorP->getX()));

        $vbp = (($coorV->getX() - $coorP->getX())*($coorB->getY() - $coorP->getY())) - (($coorV->getY() - $coorP->getY())*($coorB->getX() - $coorP->getX()));

        $bfp = (($coorB->getX() - $coorP->getX())*($coorF->getY() - $coorP->getY())) - (($coorB->getY() - $coorP->getY())*($coorF->getX() - $coorP->getX()));

        if(($fvb >= 0 && $fvp >= 0 && $vbp >= 0 && $bfp >= 0) || ($fvb < 0 && $fvp < 0 && $vbp < 0 && $bfp < 0)) {
            return true;
        }else{
            return false;
        }

    }

    private function perimetroTriangulo($coorF, $coorV, $coorB){
        $perimetro = sqrt(pow(($coorV->getX() - $coorF->getX()), 2) + pow(($coorV->getY() - $coorF->getY()), 2)) + sqrt(pow(($coorB->getX() - $coorV->getX()), 2) + pow(($coorB->getY() - $coorV->getY()), 2)) + sqrt(pow(($coorB->getX() - $coorF->getX()), 2) + pow(($coorB->getY() - $coorF->getY()), 2));

        return $perimetro;
    }

    public function getPeriodos($anios){
        $periodos_sequia = 0;
        $periodos_lluvia = 0;
        $periodos_cond_optimas = 0;
        $dia_pico_lluvia = 0;
        $perimetro = 0;
        
        for($t=1; $t <= self::DIAS_DEL_ANIO*$anios; $t++){ // $t -> es el tiempo en días.
            $clima = $this->getClima($t);
            switch ($clima) {
                case self::SEQUIA :
                $periodos_sequia++;
                break;
                case self::COND_OPTIMAS :
                $periodos_cond_optimas++;
                break;
                case self::LLUVIA :
                $periodos_lluvia++;
                $perimetro_aux = $this->perimetroTriangulo($this->getPlanetas()['F']->getCoordenada(), $this->getPlanetas()['V']->getCoordenada(), $this->getPlanetas()['B']->getCoordenada());
                if($perimetro_aux >= $perimetro){
                    $perimetro = $perimetro_aux;
                    $dia_pico_lluvia = $t;
                }
                break;
            }
        }
        return array("SEQUIA" => $periodos_sequia, "LLUVIA" => $periodos_lluvia, "MAXIMA_LLUVIA" => $dia_pico_lluvia, "CONDICIONES_OPTIMAS" => $periodos_cond_optimas);
    }

    public function getClima($t){ // $t -> tiempo en días
        // Se calculan las coordenadas y se las asignan a cada planeta, día a día. Es decir, simula el desplazamiento de los mismos.
        $this->setearCoordenada($this->getPlanetas()['F'], $t);
        $this->setearCoordenada($this->getPlanetas()['V'], $t);
        $this->setearCoordenada($this->getPlanetas()['B'], $t);
        // Una vez que tengo las coordenadas cartesianas de cada planeta seteadas, comienzo con las comprobaciones.
        if($this->isTresPuntosAlineados($this->getPlanetas()['F']->getCoordenada(), $this->getPlanetas()['V']->getCoordenada(), $this->getPlanetas()['B']->getCoordenada())){ // Si los tres planetas estan alineados, debo comprobar si estan alineados con el sol.
            if($this->isTresPuntosAlineados($this->getEstrella()->getCoordenada(), $this->getPlanetas()['F']->getCoordenada(), $this->getPlanetas()['V']->getCoordenada())){ // Utilizo la misma función ya que, si tres planetas estan alineados y dos de estos estan alineados con el sol, entonces, los cuatro estarán alineados. (SEQUIA)
                return self::SEQUIA;
            }else{ // Solo los tres planetas se encuentran alineados. (CONDICIONES OPTIMAS DE PRESION Y TEMPERATURA)
                return self::COND_OPTIMAS;
            }
        }else{ // Forman un triangulo: Comprobar si el sol esta dentro o fuera del triangulo que generan los planetas.
            $boolean = $this->isPuntoDentroTriangulo($this->getPlanetas()['F']->getCoordenada(), $this->getPlanetas()['V']->getCoordenada(), $this->getPlanetas()['B']->getCoordenada(), $this->getEstrella()->getCoordenada());
            if($boolean){
                return self::LLUVIA;
            }else{
                return self::INDEFINIDO;
            }
        }

    }

}

?>