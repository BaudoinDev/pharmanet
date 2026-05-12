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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('adresse');
            $table->string('telephone')->nullable();
            $table->string('numero_agrement')->nullable();
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee', 'suspendue'])->default('en_attente');
            $table->string('logo')->nullable();
            $table->boolean('garde')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
