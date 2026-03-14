<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'partha.business@gmail.com',
            'password' => '$2y$12$WRdjDvVzJ1E0BNmcOonTJuVJHDSEga.qU.gqn9JZhPeyj5ao3quY2',
        ]);
    }
}
