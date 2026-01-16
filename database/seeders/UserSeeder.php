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
            'username' => $username = 'superadmin',
            'role' => 'SuperAdmin',
            'division' => null,
            'password' => Hash::make($username),
        ]);
        User::factory()->create([
            'username' => $username = 'leader',
            'role' => 'Leader',
            'division' => 'Finance',
            'password' => Hash::make($username),
        ]);
        User::factory()->create([
            'username' => $username = 'member',
            'role' => 'Member',
            'division' => 'Finance',
            'password' => Hash::make($username),
        ]);

        $divisions = ['HR', 'IT'];
        foreach ($divisions as $division) {
            User::factory()->create([
                'role' => 'Leader',
                'division' => $division,
                'password' => Hash::make('leader'),
            ]);
        }
        User::factory(40)->create();
    }
}
