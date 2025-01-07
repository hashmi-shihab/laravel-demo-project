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
            $prefix = 'user';

            $table->id();
            $table->string("{$prefix}_name", 100);
            $table->string("{$prefix}_first_name", 100);
            $table->string("{$prefix}_middle_name", 100)->nullable();
            $table->string("{$prefix}_last_name", 100);
            $table->string("email");
            $table->timestamp('email_verified_at')->nullable();
            $table->string("password", 100);
            $table->rememberToken();
            $table->date("{$prefix}_birth_date")->nullable();
            $table->tinyInteger("{$prefix}_gender")->nullable();
            $table->string("{$prefix}_mobile", 25)->nullable();
            $table->string("{$prefix}_phone", 25)->nullable();
            $table->string("{$prefix}_image")->nullable();
            $table->string("{$prefix}_street_address")->nullable();
            $table->string("{$prefix}_police_station", 100)->nullable();
            $table->string("{$prefix}_city", 100)->nullable();
            $table->string("{$prefix}_zip", 25)->nullable();
            $table->string("{$prefix}_state", 100)->nullable();
            $table->string("{$prefix}_country", 100)->nullable();
            $table->integer("role_id")->nullable();
            $table->boolean("is_active")->default(true);
            $table->foreignId("created_by")->nullable()->references('id')->on('users');
            $table->foreignId("updated_by")->nullable()->references('id')->on('users');
            $table->integer("otp")->nullable();
            $table->timestamp("otp_expire_at")->nullable();
            $table->foreignId("password_updated_by")->nullable()->references('id')->on('users');
            $table->timestamp("password_updated_at")->nullable();
            $table->string("password_updated_during", 30)->nullable();
            $table->timestamps();

            $table->index([
                "{$prefix}_name",
                "{$prefix}_first_name",
                "{$prefix}_middle_name",
                "{$prefix}_last_name",
                'email',
                "{$prefix}_mobile",
                'is_active',
            ], 'users_index_composite');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
