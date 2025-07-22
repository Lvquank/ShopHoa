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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // title varchar
            $table->longText('description')->nullable(); // description varchar
            $table->string('title_seo')->nullable(); // title_seo varchar
            $table->string('author')->nullable(); // author varchar
            $table->integer('histotal')->default(0); // histotal int
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
