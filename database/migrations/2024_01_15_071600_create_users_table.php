<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $status = 'Active';
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('contact_number')->unique()->nullable();
            $table->enum('area', User::$area)->nullable();
            $table->enum('chapter', User::$chapter)->nullable();
            $table->enum('gender', User::$gender)->nullable();
            $table->string('status')->nullable()->default($status);
            $table->string('avatar')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->cascadeOnDelete();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
