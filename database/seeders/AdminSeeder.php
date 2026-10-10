<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pratham.com'],
            ['name' => 'Pratham Admin', 'password' => 'pRaThaM@98anSa', 'role' => User::ROLE_SUPER_ADMIN, 'status' => true]
        );
    }
}
