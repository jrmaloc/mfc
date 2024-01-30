<?php

use App\Models\Tithe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tithes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email');
            $table->string('contact_number');
            $table->dateTime('timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));


            $table->bigInteger('amount');
            $table->enum('mop', Tithe::$mop);
            $table->string('transaction_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tithes');
    }
};