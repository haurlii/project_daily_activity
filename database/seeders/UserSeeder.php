<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'role' => 'SuperAdmin',
            'division' => null,
            'password' => Hash::make('superadmin'),
        ]);

        $divisions = ['HR', 'IT', 'Finance'];
        foreach ($divisions as $division) {
            User::factory()->create([
                'role' => 'Leader',
                'division' => $division,
                'password' => Hash::make('leader'),
            ]);
        }
        User::factory(30)->create();
    }
}
