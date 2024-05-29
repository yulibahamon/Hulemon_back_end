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
        Schema::create('cosechas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("lote_id");
            $table->foreign('lote_id')
                ->references('id')->on('lotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('fecha_inicio_cosecha');
            $table->date('fecha_fin_cosecha')->nullable();;
            $table->string('cantidad')->nullable();;
            $table->text('observaciones')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosechas');
    }
};
