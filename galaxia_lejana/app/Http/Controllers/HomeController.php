<?php

namespace App\Http\Controllers;

use App\Clases\Coordenada;
use App\Clases\Planeta;
use App\Clases\Estrella;
use App\Clases\Galaxia;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $galaxia;

    public function __construct()
    {
    	// Cada Planeta inicia en t=0. Como Ferengi y Betasoide giran en sentido horario, su velocidad angular a fines matematicos, sera negativa. Las coordenadas son cartesianas.
    	$ferengi = new Planeta("Ferengi",new Coordenada(500,0), -1, 500);
    	$vulcano = new Planeta("Vulcano",new Coordenada(1000,0), 5, 1000);
    	$betasoide = new Planeta("Betasoide",new Coordenada(0,0), -3, 2000);

    	$sol = new Estrella("Sol", new Coordenada(0,0));

    	$this->galaxia = new Galaxia("Galaxia lejana", array("F" => $ferengi, "V" => $vulcano, "B" => $betasoide), $sol);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $periodos = $this->galaxia->getPeriodos(10); // Envio los años del periodo a calcular. (10 ańos)

        return view('welcome')->with('periodos', $periodos);
    }

    public function show($dia){

        $estado = DB::table('Clima')
        ->join('Estado_clima as Ec', 'Clima.Estado_clima_idEstado_clima', '=', 'Ec.idEstado_clima')
        ->where('Clima.dia', $dia)
        ->select('Clima.dia as dia', 'Ec.estado as clima')
        ->first();

        if(isset($estado)){
            return response()->json([
                'dia' => $estado->dia,
                'clima' => $estado->clima
            ]);
        }else{
            return response()->json([
                'error' => 'dia no encontrado'
            ]);
        }

    }
}