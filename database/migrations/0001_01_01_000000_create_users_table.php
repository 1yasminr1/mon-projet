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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('diplome')->nullable();
        $table->integer('experience')->nullable();
        $table->string('cv')->nullable();
        $table->string('specialite')->nullable();
        $table->enum('statut_formateur', ['en_attente', 'approuve', 'rejete'])->nullable();
        $table->enum('role', ['admin', 'apprenant', 'formateur'])->default('apprenant');
        $table->enum('statut', ['actif', 'bloque'])->default('actif');
        $table->string('photo')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
