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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('subadmin_id');
            $table->unsignedBigInteger('student_id')->nullable();

            // Amounts
            $table->decimal('debit_balance', 10, 2)->default(0);
            $table->decimal('avl_balance', 10, 2)->default(0);

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('subadmin_id')
                ->references('id')->on('sub_admins')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
