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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('opponent_name')->nullable();
            $table->string('opponent_type')->nullable();
            $table->string('opponent_phone')->nullable();
            $table->string('opponent_nation')->nullable();
            $table->string('opponent_address')->nullable();
            $table->string('opponent_lawyer')->nullable();
            $table->string('lawyer_phone')->nullable();
            $table->string('court_name')->nullable();
            $table->string('circle')->nullable();
            $table->string('judge_name')->nullable();
            $table->string('case_number')->nullable();
            $table->string('attorney_number')->nullable();
            $table->date('register_date')->nullable();
            $table->string('case_title')->nullable();
            $table->integer('contract_price')->nullable();
            $table->string('notes')->nullable();
            $table->integer('paid_fees')->default(0); // أضف هذا
            $table->integer('remaining_fees')->default(0); // وأضف هذا
            $table->unsignedBigInteger('case_category_id')->nullable();
            $table->foreign('case_category_id')->nullable()->references('id')->on('case_categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
