<?php

namespace Database\Seeders;

use App\Models\SubAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SubAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubAdmin::truncate();
        SubAdmin::create([
            // "name" => "Admin Lions Club",
            // "email" => "admin@mail.com",
            // "password" => Hash::make("12345"),
            // "slug" => "admin1-lions-club",

            "name" => "Sub Admin",
            "email" => "subadmin@mail.com",
            "password" => Hash::make("12345"),
            // "slug" => "admin2-portal",
      
        ]);
    }
}
