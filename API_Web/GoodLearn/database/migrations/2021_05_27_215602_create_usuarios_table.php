<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('rol_id')
            //$table->foreign('rol_id')->references('id')->on('rol')->onDelete('cascade');
            $table->foreignId('rol_id')->constrained('rol')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name', 25);
            $table->string('email', 50);
            $table->string('telefono', 15);
            $table->string('direccion', 100);
            $table->string('contraseña', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
