<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $rol = new Rol();
        $rol->name = "administrador";
        $rol->save();

        $user = new Usuario();
        $user->name = "Antonio";
        $user->email = "antonio@gmail.com";
        $user->telefono = "8235945";
        $user->direccion = "alto de las heras";
        $user->contraseña = "hola";
        $user->rol_id = 1;
        $user->save();

    }
}
