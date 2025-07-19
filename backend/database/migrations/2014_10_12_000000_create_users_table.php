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
            $table->unsignedBigInteger('role_id')->default(2); // Thêm cột role_id, mặc định là user
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable(); // Thêm cột phone_number, có thể null
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // Mật khẩu có thể null cho tài khoản MXH
            $table->string('google_id')->nullable()->unique(); // ID từ Google
            $table->string('facebook_id')->nullable()->unique(); // ID từ Facebook
            $table->string('avatar')->nullable(); // URL ảnh đại diện
            $table->string('auth_type')->default('email'); // Loại xác thực: email, google, facebook
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
