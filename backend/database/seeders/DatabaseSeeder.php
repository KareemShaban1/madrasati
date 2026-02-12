<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CurriculumSeeder::class,
            LessonContentSeeder::class,
            BadgeAchievementSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@educore.test'],
            [
                'full_name' => 'Platform Admin',
                'password' => Hash::make('Admin12345'),
                'grade_id' => null,
                'role' => 'admin',
            ]
        );
    }
}
