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
        Schema::create('case_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('amount');
            $table->date('date')->default(now());
            $table->unsignedBigInteger('case_id');
            $table->foreign('case_id')->references('id')->on('issues')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_expenses');
    }
};
