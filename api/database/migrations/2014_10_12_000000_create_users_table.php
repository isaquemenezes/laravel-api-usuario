<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 55);
            $table->string('email')->unique()->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('telefone', 12)->nullable();
            $table->string('cep', 12)->nullable();
            $table->string('estado', 25)->nullable();
            $table->string('cidade', 55)->nullable();
            $table->string('bairro', 255)->nullable();
            $table->string('endereco', 255)->nullable();

            $table->string('status', 12)->default('ativo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
