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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            // Foreign Key: subadmin_id → subadmins.id
            $table->unsignedBigInteger('subadmin_id');
            $table->foreign('subadmin_id')
                  ->references('id')
                  ->on('sub_admins')
                  ->onDelete('cascade');

            // Amount column
            $table->decimal('amount', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
