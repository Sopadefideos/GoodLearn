<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturaCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignatura_cursos', function (Blueprint $table) {
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignatura_cursos');
    }
}
