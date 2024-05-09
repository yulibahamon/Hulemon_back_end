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
        Schema::create('opciones_generales', function (Blueprint $table) {
            $table->id();
            $table->string('identificador');
            $table->string('nombre');
            $table->string('observaciones')->nullable();
            $table->unsignedBigInteger("rol_id");
            $table->foreign('rol_id')
                ->references('id')->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_generales');
    }
};
