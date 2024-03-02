<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();

        $user->name = 'moderator';
        $user->email = 'moderator@gmail.com';
        $user->role = 'moderator';
        $user->password = 'password123';

        $user->save();
    }
}
