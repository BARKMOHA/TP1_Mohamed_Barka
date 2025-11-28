<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Critic;
use Illuminate\Support\Facades\DB;

class FakeCriticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            
            // Générer 30 critiques pour chaque user
            Critic::factory()
                ->count(30)
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
