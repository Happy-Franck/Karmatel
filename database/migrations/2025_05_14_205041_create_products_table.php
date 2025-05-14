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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('quantite');
            $table->string('marque');
            $table->decimal('prix', 10, 2);
            $table->string('couleur')->nullable();
            $table->text('config')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
