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
    Schema::create('resultats', function (Blueprint $table) {
        $table->id();
        $table->integer('note');
        $table->boolean('reussi')->default(false);
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultats');
    }
};
