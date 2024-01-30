<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->bigInteger('reg_fee')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->json('role_ids')->default('[]')->nullable();
            $table->json('user_ids')->default('[]')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
