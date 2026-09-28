<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pratham.test'],
            ['name' => 'Pratham Admin', 'password' => 'password123', 'role' => User::ROLE_SUPER_ADMIN, 'status' => true]
        );
    }
}
