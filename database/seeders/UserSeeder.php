<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'  => 'Administrator',
                'email' => 'admin@rekrutmudah.test',
                'role'  => 'admin',
            ],
            [
                'name'  => 'HR Manager',
                'email' => 'hr@rekrutmudah.test',
                'role'  => 'hr',
            ],
            [
                'name'  => 'Pelamar Contoh',
                'email' => 'pelamar@rekrutmudah.test',
                'role'  => 'pelamar',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ]);
        }
    }
}
