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
        Schema::create('students', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('admin_id');
            $table->foreignUlid('city_id')->nullable();
            $table->string('nim', 15)->unique();
            $table->string('name');
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete()->cascadeOnUpdate();
            $table->date('born_date');
            $table->enum('sex', ['P', 'L']);
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
