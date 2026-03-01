<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->date('session_from')->nullable();
            $table->date('session_to')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('issue_date_certificate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn(['session_from', 'session_to', 'issue_date']);
        });
    }
};