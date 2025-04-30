<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('imagem_produtos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url_imagem');
            $table->uuid('produto_id');
            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagem_produtos');
    }
};
