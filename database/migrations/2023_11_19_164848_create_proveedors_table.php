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
        Schema::create('proveedor', function (Blueprint $table) {
            // $table->id();
            $table->string('nit', 15)->primary();
            $table->string('nombre', 100);
            $table->string('razon_social', 100);
            $table->string('categoria', 20);
            $table->string('nombre_contacto', 100);
            $table->string('telefono_contacto', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
