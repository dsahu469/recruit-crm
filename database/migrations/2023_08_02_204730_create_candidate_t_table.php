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
        Schema::create('candidate_t', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->string('department');
            $table->decimal('min_salary_expectation', 10, 2);
            $table->decimal('max_salary_expectation', 10, 2);
            $table->uuid('currency_id');
            $table->uuid('address_id');
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('owner_id')->references('id')->on('user_t');
            $table->foreign('currency_id')->references('id')->on('currency_t');
            $table->foreign('address_id')->references('id')->on('address_t');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_t');
    }
};
