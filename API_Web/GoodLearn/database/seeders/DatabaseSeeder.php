<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $rol = new Rol();
        $rol->name = "administrador";
        $rol->save();
        $rol1 = new Rol();
        $rol1->name = "profesor";
        $rol1->save();
        $rol2 = new Rol();
        $rol2->name = "alumno";
        $rol2->save();

        $user = new Usuario();
        $user->name = "Antonio";
        $user->email = "antonio@gmail.com";
        $user->telefono = "8235945";
        $user->direccion = "alto de las heras";
        $user->password = "hola";
        $user->rol_id = 1;
        $user->save();
    }
}
