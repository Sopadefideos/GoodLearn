<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentarioPublicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario_publicacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('publicacion_id')->constrained('publicacions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('comentario', 200);
            $table->datetime('fecha_creacion');
            $table->datetime('fecha_modificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario_publicacions');
    }
}
