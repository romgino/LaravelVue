<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nome',150);
            $table->string('resp',150)->nullable();
            $table->string('endereco')->nullable();
            $table->string('fone',150)->nullable();
            $table->string('email',150)->nullable();

            $table->text('obs')->nullable();
            $table->text('historico')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}
