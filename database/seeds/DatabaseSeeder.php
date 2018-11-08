<?php

use App\User;
use App\Alumnos;
use App\Materias;
use App\Calificaciones;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Alumnos::truncate();
        Materias::truncate();
        Calificaciones::truncate();

        $cantidad_alumnos = 5;
        $cantidad_materias = 5;
        

        factory(User::class, $cantidad_alumnos)->create();
        factory(Alumnos::class, $cantidad_alumnos)->create();
        factory(Materias::class, $cantidad_materias)->create();
        

    }
}
