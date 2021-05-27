<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tipo_id')->constrained('tipo_notificacions')->onDelete('cascade')->onUpdate('cascade');
            $table->datetime('fecha_creacion');
            $table->datetime('fecha_lectura');
            $table->smallInteger('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacions');
    }
}
