<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emisor_id')->constrained('usuario')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('receptor_id')->constrained('usuario')->onDelete('cascade')->onUpdate('cascade');
            $table->string('texto');
            $table->datetime('fecha_creacion');
            $table->datetime('fecha_modificacion');
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
        Schema::dropIfExists('mensajes');
    }
}
