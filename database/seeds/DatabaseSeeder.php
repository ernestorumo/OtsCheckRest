<?php

use App\Incidencia;
use App\IncidenciaTipo;
use App\Tienda;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        User::truncate();
        Tienda::truncate();
        Incidencia::truncate();
        IncidenciaTipo::truncate();
               
        $cantidadUsuarios = 10;
        $cantidadTiendas = 20;
        $cantidadIncidenciaTipo = 4;
        $cantidadIncidencia = 40;
        
        factory(User::class, $cantidadUsuarios)->create();
        factory(Tienda::class, $cantidadTiendas)->create();
        factory(IncidenciaTipo::class, $cantidadIncidenciaTipo)->create();
        factory(Incidencia::class, $cantidadIncidencia)->create();
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
