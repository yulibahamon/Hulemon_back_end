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
        Schema::create('fertilizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("lote_id");
            $table->foreign('lote_id')
                ->references('id')->on('lotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('fecha_fertilizacion');
            $table->string('metodo_fertilizacion')->nullable();;
            $table->string('nombre_insumo')->nullable();;
            $table->string('observaciones')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizaciones');
    }
};
