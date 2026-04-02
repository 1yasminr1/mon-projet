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
    Schema::create('quiz', function (Blueprint $table) {
        $table->id();
        $table->string('question');
        $table->string('reponse_a');
        $table->string('reponse_b');
        $table->string('reponse_c');
        $table->string('reponse_d');
        $table->enum('bonne_reponse', ['a', 'b', 'c', 'd']);
        $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
