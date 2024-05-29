<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opciones_especificas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("opcion_general_id");
            $table->foreign('opcion_general_id')
                ->references('id')->on('opciones_generales')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('identificador');
            $table->string('nombre');
            $table->string('observaciones')->nullable();
            $table->integer("notificacion");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_especificas');
    }
};
