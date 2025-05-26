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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('ID_number')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('company_name')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId(column: 'user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('customer_category_id')->nullable();
            $table->foreign('customer_category_id')->nullable()->references('id')->on('customer_categories')->onDelete('set null');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
