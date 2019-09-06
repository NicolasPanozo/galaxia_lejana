<?php

namespace App\Console\Commands;

use App\Clases\Coordenada;
use App\Clases\Planeta;
use App\Clases\Estrella;
use App\Clases\Galaxia;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CargarDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DB:clima';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Carga los días en la tabla clima de la DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('clima')->truncate();

        // Cada Planeta inicia en t=0. Como Ferengi y Betasoide giran en sentido horario, su velocidad angular a fines matematicos, sera negativa. Las coordenadas son cartesianas.
        $ferengi = new Planeta("Ferengi",new Coordenada(500,0), -1, 500);
        $vulcano = new Planeta("Vulcano",new Coordenada(1000,0), 5, 1000);
        $betasoide = new Planeta("Betasoide",new Coordenada(0,0), -3, 2000);

        $sol = new Estrella("Sol", new Coordenada(0,0));

        $galaxia = new Galaxia("Galaxia lejana", array("F" => $ferengi, "V" => $vulcano, "B" => $betasoide), $sol);

        for($t=1; $t <= $galaxia::DIAS_DEL_ANIO*10; $t++){ //$t día
            $clima = $galaxia->getClima($t);
            DB::table('Clima')->where('#')->insert(array('dia' => $t, 'Estado_clima_idEstado_clima' => $clima));
             Log::info('Insertado en DB día: '.$t);
        }
    }
}