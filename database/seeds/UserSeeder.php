<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'info@admin.com',
            'password' => bcrypt('admin5050'),
        ]);

        $user->attachRole('super_admin');
    }
}
