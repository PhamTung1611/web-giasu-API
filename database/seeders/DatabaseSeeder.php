<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            JobSeeder::class,
            TimeSlotSeeder::class,
<<<<<<< HEAD
            // RankSalarySeeder::class,
=======
>>>>>>> f6e7d00c2d3ae3c39b6c497efa0df5299e3baaec
            UserSeeder::class,
            ClassLevelSeeder::class,
            SubjectSeeder::class,
            SchoolSeeder::class,
            FeedBackSeeder::class,
            RoleSeeder::class,
            EducationSeeder::class
        ]);
    }
}
