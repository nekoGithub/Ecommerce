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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade'); // llave foranea con el usuario

            $table->integer('type'); // campo tipo

            $table->string('description'); // campo descripcion

            $table->string('district'); // campo distrito

            $table->string('reference'); // campo referencia

            $table->integer('receiver'); // campo receptor de la compra

            $table->json('receiver_info'); // informacion del receptor

            $table->boolean('default')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
