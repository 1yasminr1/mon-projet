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
    Schema::create('formations', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->text('description');
        $table->decimal('prix', 8, 2)->default(0);
        $table->string('image')->nullable();
        $table->integer('duree')->nullable();
        $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('sous_categorie_id')->constrained('sous_categories')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
