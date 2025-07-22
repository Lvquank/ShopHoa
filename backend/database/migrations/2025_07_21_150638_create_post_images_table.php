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
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('url'); // Lưu đường dẫn tới ảnh, ví dụ: /storage/posts/anh.jpg
            $table->string('caption')->nullable(); // Chú thích ảnh (không bắt buộc)
            $table->unsignedInteger('order')->default(0); // Thứ tự xuất hiện của ảnh
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
