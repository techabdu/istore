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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_asset', 10, 2)->default(0.00);
            $table->decimal('total_expenses', 10, 2)->default(0.00);
            $table->decimal('total_debt', 10, 2)->default(0.00);
            $table->decimal('total_cash', 10, 2)->default(0.00);
            $table->decimal('capital', 10, 2)->default(0.00);
            $table->decimal('profit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
