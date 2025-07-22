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
        Schema::create('post_reviews', function (Blueprint $table) {
            // Cột ID tự tăng, khóa chính
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id')->nullable();

            // Cột tên người bình luận, không được để trống
            $table->string('name');

            // Cột email người bình luận, không được để trống
            $table->string('email');

            // Cột trang web, có thể để trống (nullable)
            $table->string('website')->nullable();

            // Cột nội dung bình luận, kiểu TEXT để chứa được nội dung dài
            $table->text('comment');

            // Tự động tạo 2 cột: created_at và updated_at
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reviews');
    }
};
