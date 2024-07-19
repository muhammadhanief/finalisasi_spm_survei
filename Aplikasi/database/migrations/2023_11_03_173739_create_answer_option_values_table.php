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
        Schema::create('answer_option_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_option_id')->nullable();
            $table->foreign('answer_option_id')->references('id')->on('answer_options');
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_option_values');
    }
};
