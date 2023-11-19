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
        Schema::create('producto_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nit_proveedor',  15);
            $table->string('codigo',  15);
            $table->string('nombre',  100);
            $table->float('precio',  15, 0);
            $table->integer('cantidad_minima');
            $table->timestamps();

            $table->foreign('nit_proveedor')->references('nit')->on('proveedor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_servicios');
    }
};
