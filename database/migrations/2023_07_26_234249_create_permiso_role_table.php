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
        Schema::create('permiso_role', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("permiso_id")->unsigned();
            $table->unsignedBigInteger("role_id");

            $table->foreign("role_id")->references("id")->on("roles");
            $table->foreign("permiso_id")->references("id")->on("permisos");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_role');
    }
};
