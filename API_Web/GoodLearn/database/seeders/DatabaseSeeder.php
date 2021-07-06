<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{Rol, Usuario, Tipo_notificacion};

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
        $rol3 = new Rol();
        $rol3->name = "padre";
        $rol3->save();

        $user = new Usuario();
        $user->name = "Antonio";
        $user->email = "antonio@gmail.com";
        $user->telefono = "8235945";
        $user->direccion = "alto de las heras";
        $user->password = "hola";
        $user->rol_id = 1;
        $user->save();

        $notificacion1 = new Tipo_notificacion();
        $notificacion1->nombre_tipo = "mensaje";
        $notificacion1->titulo = "Tienes mensajes sin leer";
        $notificacion1->cuerpo = "Tienes mensajes sin leer";
        $notificacion1->save();

        $notificacion2 = new Tipo_notificacion();
        $notificacion2->nombre_tipo = "contenido";
        $notificacion2->titulo = "Tienes contenidos sin ver";
        $notificacion2->cuerpo = "Tienes contenidos sin ver";
        $notificacion2->save();

        $notificacion3 = new Tipo_notificacion();
        $notificacion3->nombre_tipo = "autorizacion";
        $notificacion3->titulo = "Tienes autorizaciones sin ver";
        $notificacion3->cuerpo = "Tienes autorizaciones sin ver";
        $notificacion3->save();

        $notificacion3 = new Tipo_notificacion();
        $notificacion3->nombre_tipo = "nota";
        $notificacion3->titulo = "Tienes calificaciones sin ver";
        $notificacion3->cuerpo = "Tienes calificaciones sin ver";
        $notificacion3->save();

        $notificacion3 = new Tipo_notificacion();
        $notificacion3->nombre_tipo = "asistencia";
        $notificacion3->titulo = "Tienes faltas de asistencias sin ver";
        $notificacion3->cuerpo = "Tienes faltas de asistencias sin ver";
        $notificacion3->save();
    }
}
