<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '田中',
                'under_name' => '太郎',
                'over_name_kana' => 'タナカ',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'tanaka@example.com',
                'sex' => 1,
                'birth_day' => '1990-01-01',
                'role' => 1,
                'password' => Hash::make('password123'),
                'remember_token' => null,
            ],
            [
                'over_name' => '山田',
                'under_name' => '花子',
                'over_name_kana' => 'ヤマダ',
                'under_name_kana' => 'ハナコ',
                'mail_address' => 'yamada@example.com',
                'sex' => 2,
                'birth_day' => '1992-05-15',
                'role' => 2,
                'password' => Hash::make('admin123'),
                'remember_token' => null,
            ],
        ]);
    }
}
