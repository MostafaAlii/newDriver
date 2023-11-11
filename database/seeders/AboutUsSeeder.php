<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('about_us')->truncate();
        AboutUs::create([
            'notes'          =>  fake()->paragraph(),
            'photo'         =>  fake()->imageUrl(),
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
