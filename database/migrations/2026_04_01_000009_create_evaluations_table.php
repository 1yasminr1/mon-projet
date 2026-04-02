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
    Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['quiz', 'examen']);
        $table->string('titre');
        $table->integer('note_min')->default(10);
        $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
