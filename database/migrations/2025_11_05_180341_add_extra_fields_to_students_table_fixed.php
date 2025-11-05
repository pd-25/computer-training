<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('phone');
            $table->date('dob')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('enrollment_no')->nullable();
            $table->string('image')->nullable();
            $table->string('org_name')->nullable();
        });

        // Fill enrollment_no with unique IDs for existing rows
        $students = DB::table('students')->get();
        foreach ($students as $index => $student) {
            DB::table('students')
                ->where('id', $student->id)
                ->update(['enrollment_no' => 'STU-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)]);
        }

        // Now safely add unique constraint
        Schema::table('students', function (Blueprint $table) {
            $table->unique('enrollment_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['enrollment_no']);
            $table->dropColumn([
                'father_name',
                'dob',
                'admission_date',
                'enrollment_no',
                'image',
                'org_name',
            ]);
        });
    }
};
