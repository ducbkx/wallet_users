<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $admin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'gender' => User::SEX_MALE,
            'is_admin' => true,
            'code' => '1',
            'created_at' => $now,
            'updated_at' => $now
        ];
        User::insert($admin);
    }
}
