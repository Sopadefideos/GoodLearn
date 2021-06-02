<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade')->onUpdate('cascade');
            $table->string('url_autorizacion', 50);
            $table->smallInteger('estado');
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
        Schema::dropIfExists('autorizacions');
    }
}
